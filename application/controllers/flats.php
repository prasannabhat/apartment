<?php

class Flats_Controller extends Base_Controller {

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
		return View::make('home.flats');
	}

	public function get_flat($flat_id = -1)
	{
		//Default array for creating a new form
		$flat = array ( 'house_no' => '', 'floor' => '', 'block' => '', 'notes' => '');
		// If the session has data because of redirect, use that data
		if(count(Input::old()) != 0)
		{
			$flat = Input::old();
		}
		else
		{
			// Get data from the database
			if($flat_id != -1)
			{
				$flat = House::find($flat_id);
				$flat = $flat->to_array();
			}
		}
		$flat['flat_id'] = $flat_id;
		return View::make('home.flat',$flat);			
	}

	public function post_flat()
	{
		$input = Input::get();
		
		// Get the relevant rules for validation
		$rules = IoC::resolve('flat_validator');
		$validation = Validator::make($input, $rules);
		if ($validation->fails())
		{
		    return Redirect::back()->with_input()->with_errors($validation);
		}
		else
		{
			$house = House::create(array('house_no' => $input['house_no'], 'floor' => $input['floor'], 'notes' => $input['notes']));
			return Redirect::to('flats');
		}
		
	}

	public function put_flat($flat_id)
	{
		$house = House::find($flat_id);
		$input = Input::get();

		// Get the relevant rules for validation
		$rules = IoC::resolve('flat_validator',array('id' => $flat_id));
		$validation = Validator::make($input, $rules);

		if ($validation->fails())
		{
		    return Redirect::back()->with_input()->with_errors($validation);
		}
		else
		{
			$house->house_no = $input['house_no'];
			$house->floor = $input['floor'];
			$house->notes = $input['notes'];
			$house->save();
			return Redirect::to('flats');
		}


	}

	public function delete_flat($flat_id)
	{
		$house = House::find($flat_id);
		$house->delete();
		return Redirect::to('flats');
	}

	function get_members($flat_id)
	{
		$action = Input::get('action');
		
		switch ($action) {
			case 'edit':
				$member_id = Input::get('member');
				$user = User::find($member_id);
				
				$flat_relation['action'] = $action;
				$flat_relation['name'] = $user->name;
				$flat_relation['member_id'] = $member_id;
				
				// Default values
				$flat_relation['relation'] = '';
				$flat_relation['residing'] = 0;
				
				// If the session has data because of redirect, use that data
				if(count(Input::old()) != 0){
					$flat_relation['relation'] = Input::old('relation');
					$flat_relation['residing'] = Input::old('residing');						
				}
				else{
					$pivot = HouseUser::where('user_id', '=' , $member_id)->where('house_id' , '=', $flat_id)->first();
					if($pivot)
					{
						$flat_relation['relation'] = $pivot->relation;
						if($pivot->residing == 1)
						{
							$flat_relation['residing'] = 1;
						}
						// To overcome laravel bug, manually work with intermediate tables
					}
				}

				return View::make('home.flatmemberrel',$flat_relation);
				# code...
				break;
				
			case 'add':
				// If the session has data because of redirect, use that data
				if(count(Input::old()) != 0){
					$flat_relation = Input::old();
				}
				else{
					$flat_relation = array();					
				}
				$flat_relation['action'] = $action;

				$members = User::order_by('name','asc')->get();
				function get_members($result, $member){
					$result = $result . sprintf("'%s'",$member->name ). ",";
					return $result;
				}
				$members_array = array_reduce($members, "get_members");
				$members_array = rtrim($members_array,",");
				$members_array = '['. $members_array . ']';
				$flat_relation['members_array'] = $members_array;
				return View::make('home.flatmemberrel',$flat_relation);
				
				break;
			
			default:
				$flat = House::find($flat_id);
				$flat = $flat->to_array();
				$flat['flat_id'] = $flat_id;
				// Store the current URL, to navigate back to this view from the next view
				Session::put('back-url', URL::current());
				return View::make('home.flatmembers',$flat);
				break;
		}
	}

	function put_members($flat_id)
	{
		$action = Input::get('action');
		if($action == 'edit')
		{
			$input = Input::get();
			// Get the relevant rules for validation
			$params['flat_id'] = $flat_id;
			$params['action'] = $action;
			$params['name'] = Input::get('name');
			$rules = IoC::resolve('flat_relation_validator',array('params' => $params));
			
			$validation = Validator::make($input, $rules);
			if ($validation->fails())
			{
			    return Redirect::back()->with_input()->with_errors($validation);
			}
			else
			{
				$member_id = Input::get('member');
				$pivot = HouseUser::where('user_id', '=' , $member_id)->where('house_id' , '=', $flat_id)->first();
				$pivot->relation = Input::get('relation');
				$pivot->residing = Input::get('residing') ? 1 : 0;
				$pivot->save();
				$url = Apartment\Constants::ROUTE_FLAT_MEMBERS . $flat_id;
				return Redirect::to($url);
			}
		}
	}
	
	function post_members($flat_id)
	{
		$action = Input::get('action');
		$input = Input::get();
		//We are adding a new member to flat
		if($action == 'add')
		{
			// Get the relevant rules for validation
			$params['flat_id'] = $flat_id;
			$params['action'] = $action;
			$params['name'] = Input::get('name');
			$rules = IoC::resolve('flat_relation_validator',array('params' => $params));
			$validation = Validator::make($input, $rules);
			if ($validation->fails())
			{
			    return Redirect::back()->with_input()->with_errors($validation);
			}
			else
			{
				$flat_relation['relation'] = Input::get('relation');
				$flat_relation['residing'] = Input::get('residing') ? 1 : 0;
				
				$member = User::where('name', '=', Input::get('name'))->first();
				$member->houses()->attach($flat_id,$flat_relation);

				$url = Apartment\Constants::ROUTE_FLAT_MEMBERS . $flat_id;
				return Redirect::to($url);
			}

		}
	}

	function delete_members($flat_id)
	{
		$member_id = Input::get('member');
		$pivot = HouseUser::where('user_id', '=' , $member_id)->where('house_id' , '=', $flat_id)->first();
		$pivot->delete();
		$url = Apartment\Constants::ROUTE_FLAT_MEMBERS . $flat_id;
		return Redirect::to($url);
	}
	
}