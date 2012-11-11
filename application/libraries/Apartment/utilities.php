<?php
namespace Apartment;

/**
* 
*/
class Utilities
{
	public static function get_flat_validations($id) {
		$flats = \Config::get('apartment.floors');

		$flat_pattern = \Config::get('apartment.flat_pattern');

		$house_rule = sprintf('required|match:"%s"|unique:houses,house_no,%s', $flat_pattern,$id);
		$floor_rule = sprintf('required|in:%s',implode(",", $flats));
		$block_rule = 'alpha_num';
		// Add block validations, if block exists
		if(\Config::get('apartment.blocks'))
		{
			$blocks = \Config::get('apartment.blocks');
			$block_rule = sprintf('required|in:%s',implode(",", $blocks));			
		}
		\Log::info('block rule is ' . $block_rule);
		$rules = array(
			'house_no'  => $house_rule,
			'floor' => $floor_rule,
			'block' => $block_rule,
		);
		return $rules;
    }

	public static function get_member_validations($id) {
		\Log::info('member id is ' . $id);
		$name_rule = sprintf('required|match:"/^\w[\w\s]+/"|between:4,50|unique:users,name,%s',$id);
		// $email_rule = sprintf('email|custom_email');
		$email_rule = sprintf('email|unique:users,email,%s',$id);
		$rules = array(
			'name' => $name_rule,
			'phone_no' => 'match:"/^\d{10}\s*$/"',
			'email' => $email_rule
			// 'relation' => 'required'
		);
		return $rules;
    }

	public static function get_password_validations(Array $params) {
		\Validator::register('password_match', function($attribute, $value, $parameters)
		{
			$id = $parameters[0];
			\Log::info('Id inside is ' . $id);
			$is_valid = true;

			$user = \User::find($id);
			if( !\Hash::check($value, $user->password))
			{
				$is_valid = false;
			}
			return $is_valid; 
		});

		$id = $params['member_id'];
		$current_password_rule = sprintf('required|password_match:%s',$id);
		$rules = array(
			'current' => $current_password_rule,
			'new' => 'required|between:4,25',
			'verify' => 'required|same:new'
		);
		return $rules;
    }    
	
	public static function get_flat_relation_validations(Array $params) {
		\Validator::register('flat_unique_members', function($attribute, $value, $parameters)
		{
			$flat_id = $parameters[0];
			$is_valid = true;
					
			switch ($attribute) {
				case 'name':
					$flat = \House::find($flat_id);
					$member_name = $value;
					// The member name supplied should not be already existing for the given flat
					foreach($flat->users()->get() as $user)
					{
						if($member_name == $user->name)
						{
							$is_valid = false;
							break;
						}
					}
					
					
					break;
				
				default:
					
					break;
			}
			return $is_valid; 
		});
		
		\Validator::register('flat_member_relation', function($attribute, $value, $parameters)
		{
			$flat_id = $parameters[0];
			$member_name = $parameters[1];
			$is_valid = true;
					
			switch ($attribute) {
				case 'relation':
					$flat = \House::find($flat_id);
					//There can be only one owner for the flat
					$owner = NULL;
					$tenant = NULL;
					
					foreach ($flat->users as $member){
						//Set the owner , only if not set already
						if(($owner == NULL) && ($member->pivot->relation == 'owner')){
							$owner = $member;
						}
						//Set the tenant , only if not set already
						if(($tenant == NULL) && ($member->pivot->relation == 'tenant')){
							$tenant = $member;
						}
					}
					//If the owner already exists, then he should be the current member himself, as two owners are not allowed for a flat
					if(($value == 'owner') && ($owner != NULL) && ($owner->name != $member_name)){
						return false;
					}
					//If the tenant already exists, then he should be the current member himself, as two tenants are not allowed for a flat
					if(($value == 'tenant') && ($tenant != NULL) && ($tenant->name != $member_name)){
						return false;
					}									
					break;
				
				default:
					
					break;
			}
			return $is_valid; 
		});
		
		$action = $params['action'];
		$flat_id = $params['flat_id'];
		$name = $params['name'];
				
		if($action == 'add') {
			//The detailed rule is applicable only if we are adding a new member
			$name_rule = sprintf('required|match:"/^\w[\w\s]+/"|between:4,50|exists:users|flat_unique_members:%s',$flat_id);
		}
		elseif ($action == 'edit') {
			$name_rule = 'required';
				
		}
		else {
			
		}
		
		//The detailed rule is applicable only if we are adding a new member
		$owner_rule = sprintf('required|flat_member_relation:%s,%s',$flat_id,$name);
		
		$rules = array(
			'name' => $name_rule,
			'relation' => $owner_rule
		);
		return $rules;
    }    

	public static function start_app()
	{
		//Register some IoC containers
		\IoC::register('flat_validator', function($id = -1){
		    $rules = Utilities::get_flat_validations($id);
		    return $rules;
		});

		\IoC::register('member_validator', function($id = -1){
		    $rules = Utilities::get_member_validations($id);
		    return $rules;
		});		

		\IoC::register('password_validator', function(Array $params=array()){
		    \Log::info('Resolve password_validator : parameters are ' . json_encode($params));
		    $rules = Utilities::get_password_validations($params);
		    return $rules;
		});		
		
		\IoC::register('flat_relation_validator', function(Array $params=array()){
			\Log::info('Resolve flat_relation_validator : parameters are ' . json_encode($params));
		    $rules = Utilities::get_flat_relation_validations($params);
		    return $rules;
		});		

	}
	

	public static function get_member_flat_relations()
	{
		$MEMBER_FLAT_RELATION = array("Owner" => "owner","Co Owner" => "co-owner", "Owner's Family" => "owners-family",
	    		"Tenant" => "tenant", "Tenant's Family" => "tenant-family");
		return $MEMBER_FLAT_RELATION;

	}

	public static function send_sms($gateway, Array $phones, $message, $delay=0)
	{
		$messages = new \Laravel\Messages;
		$success_count = 0;
    		
    	switch ($gateway) {
			case 'way2sms':
				$sms = new \Sms\Way2sms();
				break;

			case '160by2':
				$sms = new \Sms\SixByTwo();
				break;    				

			case 'fullonsms':
				$sms = new \Sms\FullOnSms();
				break;    				    				
			
			default:
				$sms = new \Sms\Way2sms();
				break;
    		}
		$credentials = \Config::get('apartment.sms_gateways');
		$credentials = $credentials[$gateway];
// 		Valid credentials are not found in the configuration for the chosen gateway
		if(!is_array($credentials))
		{
			$messages->add('error',"No login details found for $gateway\n");
			return $messages;
		}

		
		$result = $sms->login($credentials['login'], $credentials['password']);
		if ($result)
		{
			foreach ($phones as $phone) {
				$result = $sms->send($phone,$message);			
				if($result)
				{
					$success_count++;
					$messages->add('details', "SMS sent successfully to $phone\n");
				}
				else
				{
					$messages->add('details', "SMS could not be sent successfully to $phone\n");

				}
				sleep($delay);
			}
			$total_count = count($phones);
			$messages->add('result',"SMS sent to $success_count out of $total_count\n");			
		} else 
		{
			$messages->add('error',"Login failed for $gateway\n");
		}

		return $messages;

	}  

	public static function get_all_users()
	{
		$users = \User::order_by('name','asc')->get();
		$users = \array_pluck($users,'name');
		return $users;
	}

}
