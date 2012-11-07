<?php

class Communication_Controller extends Base_Controller {
	public $restful = true;
	/*
	|--------------------------------------------------------------------------
	| The Default Controller
	|--------------------------------------------------------------------------
	|
	| Instead of using RESTful routes and anonymous functions, you might wish
	| to use controllers to organize your application API. You'll love them.
	|
	| This controller responds to URIs beginning with "home", and it also
	| serves as the default controller for the application, meaning it
	| handles requests to the root of the application.
	|
	| You can respond to GET requests to "/home/profile" like so:
	|
	|		public function action_profile()
	|		{
	|			return "This is your profile!";
	|		}
	|
	| Any extra segments are passed to the method as parameters:
	|
	|		public function action_profile($id)
	|		{
	|			return "This is the profile for user {$id}.";
	|		}
	|
	*/
	public function get_index()
	{
		$view_params['base_url'] = URL::current();

		$flats = House::order_by('house_no','asc')->get();
		function get_flats($result, $flat){
			$result = $result . sprintf("'%s'",$flat->house_no ). ",";
			return $result;
		}
		$flats_array = array_reduce($flats, "get_flats");
		$flats_array = rtrim($flats_array,",");
		$flats_array = '['. $flats_array . ']';
		$view_params['flats_array'] = $flats_array;		
		return View::make('home.communication',$view_params);
	}

	private function get_user_array($flat, $user)
	{
		//Get the readable string of the relationship
		$relation_map = Apartment\Utilities::get_member_flat_relations();
		$custom_user = array();
		$custom_user['name'] = $user->name;
		$custom_user['phone'] = $user->phone;
		$custom_user['house_no'] = $flat->house_no;
		$custom_user['relation'] = array_search($user->pivot->relation, $relation_map);
		$custom_user['residing'] = $user->pivot->residing ? "yes" : "no";
		return $custom_user;
	}

	private function get_users($data)
	{
		$flats = array();
		$users = array();
		if($data->sms_type == "group")
		{
			// Select the flats to send message to
			if($data->floor == "all")
			{
				$flats = House::get();
			}
			else
			{
				$flats = House::where('floor','=',$data->floor)->get();
			}    			

		}
		elseif ($data->sms_type == "single") {
			$selected_flats = $data->selected_flats;
			$selected_flats = explode(",", $selected_flats);
			$flats = House::where_in('house_no',$selected_flats)->get();
		}
		else{

		}

		switch($data->group)
		{
			case "owner":
	    		foreach($flats as $flat)
	    		{
	    			if($flat->owner){
	    				// Get the custom array
	    				$user = $this->get_user_array($flat,$flat->owner);
	    				array_push($users, $user);
	    			}
	    		}
			break;

			case "owners":
	    		foreach($flats as $flat)
	    		{
	    			foreach($flat->users as $user){
				 		$relation = $user->pivot->relation;
				 		$select = (($relation == 'owner') || ($relation == 'co-owner') || ($relation == 'owners-family')) ? true : false;
						if($select){
							// Get the custom array
		    				$user = $this->get_user_array($flat,$user);
		    				array_push($users, $user);
						}
	    			}
	    		}
			break;    		

			case "tenant":
	    		foreach($flats as $flat)
	    		{
	    			if($flat->tenant){
	    				// Get the custom array
	    				$user = $this->get_user_array($flat,$flat->tenant);
	    				array_push($users, $user);	    				
	    			}
	    		}
			break;    		

			case "tenants":
				foreach($flats as $flat)
				{
					foreach ($flat->tenants as $tenant) {
						// Get the custom array
	    				$user = $this->get_user_array($flat,$tenant);
	    				array_push($users, $user);	    				
					}
				}
			break;

			case "resident":
	    		foreach($flats as $flat)
	    		{
	    			if($flat->resident){
	    				// Get the custom array
	    				$user = $this->get_user_array($flat,$flat->resident);
	    				array_push($users, $user);	    				
	    			}
	    		}
			break;

			case "residents":
				foreach($flats as $flat)
				{
					foreach ($flat->residents as $user) {
						// Get the custom array
	    				$user = $this->get_user_array($flat,$user);
	    				array_push($users, $user);	    				
					}
				}
			break;

			case "all":
				foreach($flats as $flat)
				{
					foreach ($flat->users as $user) {
						// Get the custom array
	    				$user = $this->get_user_array($flat,$user);
	    				array_push($users, $user);	    				
					}
				}
			break;    		    					
		}
		return $users;

	}	

	public function post_index()
	{
		$data = Input::json();
		$response = array(
	        'error' => 0,
	        'message'	=> 'sent to all people',
    	);

    	$users = array();
    	// Send sms for flats
    	if($data->target == "flats")
    	{
    		$users = $this->get_users($data);
    	}

    	if($data->action == "list_users")
    	{
    		return Response::json($users);
    	}


		// Filter the users with phone numbers
		$user_with_phones = array_filter($users,function ($user){
			$select = ($user['phone']) ? true : false;
			return $select;
    	});    	

		// Get the phone numbers alone
		$phones = array_map(function ($user){
    		return $user['phone'];
    	},$user_with_phones);
    	$phones = array_unique($phones);

    	if(strlen(trim($data->message)) == 0)
    	{
    		$response['error'] = 1;
    		$response['message'] = 'No message to send';
    	}

    	if(count($phones) == 0)
    	{
    		$response['error'] = 1;
    		$response['message'] = 'No members to send message!';
    	}

		// The number used to send message
		// Delete this number, if it exists and add it at the end
		$credentials = Config::get('apartment.sms_gateways');
		$credentials = $credentials[$data->gateway];
    	$test_phone = $credentials['login'];
		
    	if (in_array($test_phone, $phones)) 
		{
		    unset($phones[array_search($test_phone,$phones)]);
		}

		$names = array_map(function ($user){
    		return $user['name'];
    	},$users);
    	array_push($phones, $test_phone);

    	$response['phones'] = $phones;
    	$response['phones_count'] = count($phones);

    	if($data->action == "list_numbers")
    	{
    		$response['message'] = "Listing numbers to send message to";
    		return Response::json($response);
    	}

    	if(!$response['error'])
    	{
    		$response['message'] = Apartment\Utilities::send_sms($data->gateway,$phones,$data->message);
    	}

		// return Response::json($phones);
		return Response::json($response);

	}
}