<?php
namespace Apartment;

/**
* 
*/
class Utilities
{
	public static function get_flat_validations($id) {
		\Log::info('id is ' . $id);
		$house_rule = sprintf('required|match:"/^[ABCDE]\d{1,2}/"|unique:houses,house_no,%s', $id);
		$rules = array(
			'house_no'  => $house_rule,
			'floor' => 'required|in:A,B,C,D,E'
		);
		return $rules;
    }

	public static function get_member_validations($id) {
		\Log::info('member id is ' . $id);
		$name_rule = sprintf('required|match:"/^\w[\w\s]+/"|between:5,50|unique:users,name,%s',$id);
		$email_rule = sprintf('email|unique:users,email,%s',$id);
		$rules = array(
			'name' => $name_rule,
			'phone_no' => 'required|match:"/^\d{10}\s*$/"',
			'email' => $email_rule
			// 'relation' => 'required'
		);
		return $rules;
    }
	
	public static function get_flat_relation_validations(Array $params) {
		
		$action = $params['action'];
		$flat_id = $params['flat_id'];
		\Validator::register('flat_relation', function($attribute, $value, $parameters)
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
		
		\Validator::register('flat_relation_owner', function($attribute, $value, $parameters)
		{
			$flat_id = $parameters[0];
			$member_id = $parameters[1];
			$is_valid = true;
					
			switch ($attribute) {
				case 'relation':
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
				
		if($action == 'add') {
			//The detailed rule is applicable only if we are adding a new member
			$name_rule = sprintf('required|match:"/^\w[\w\s]+/"|between:5,50|exists:users|flat_relation:%s',$flat_id);
		}
		elseif ($action == 'edit') {
			$name_rule = 'required';
				
		}
		else {
			
		}
		
		//The detailed rule is applicable only if we are adding a new member
		$owner_rule = sprintf('required|match:"/^\w[\w\s]+/"|between:5,50|exists:users|flat_relation:%s',$flat_id);
		
		$rules = array(
			'name' => $name_rule,
			'relation' => 'required'
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

}
