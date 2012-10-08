<?php

class Members_Controller extends Base_Controller {
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
		return View::make('home.members');
	}

	public function get_member($member_id = -1)
	{
		//Default array for creating a new member
		$member = array ( 'name' => '', 'email' => '', 'phone_no' => '','relation' => '', 'residing' => '');
		// If the session has data because of redirect, use that data
		if(count(Input::old()) != 0)
		{
			$member = Input::old();
		}
		else
		{
			// Get data from the database
			if($member_id != -1)
			{
				// $flat = House::find($flat_id);
				// $flat = $flat->to_array();
			}
		}
		$member['member_id'] = $member_id;
		return View::make('home.member',$member);			
	}

	public function post_member()
	{
		$input = Input::get();
		// Get the relevant rules for validation
		$rules = IoC::resolve('member_validator');
		$validation = Validator::make($input, $rules);
		if ($validation->fails())
		{
		    return Redirect::back()->with_input()->with_errors($validation);
		}
		else
		{
			return Redirect::back();
		}		

	}

	public function post_flat()
	{
		$input = Input::get();
		
		// Get the relevant rules for validation
		$rules = IoC::resolve('validator');
		$validation = Validator::make($input, $rules);
		if ($validation->fails())
		{
		    return Redirect::back()->with_input()->with_errors($validation);
		}
		else
		{
			$house = House::create(array('house_no' => $input['house_no'], 'floor' => $input['floor']));
			return Redirect::to('flats');
		}
		
	}

	public function put_flat($flat_id)
	{
		$house = House::find($flat_id);
		$input = Input::get();

		// Get the relevant rules for validation
		$rules = IoC::resolve('validator',array('id' => $flat_id));
		$validation = Validator::make($input, $rules);

		if ($validation->fails())
		{
		    return Redirect::back()->with_input()->with_errors($validation);
		}
		else
		{
			$house->house_no = $input['house_no'];
			$house->floor = $input['floor'];
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

}
