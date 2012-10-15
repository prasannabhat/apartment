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
		$flat_id = Input::get('flat_id');
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
				$user = User::with(array('phones'))->find($member_id);
				$member['name'] = $user->name;
				$member['email'] = $user->email;
				$member['phone_no'] = $user->phone;
				if($flat_id)
				{
					foreach($user->houses()->pivot()->get() as $row)
					{
						if ($row->house_id == $flat_id)
						{
							$member['relation'] = $row->relation;
							$member['residing'] = $row->residing;
							break;
						}
					}
				}

				// $flat = House::find($flat_id);
				// $flat = $flat->to_array();
			}
		}
		$member['member_id'] = $member_id;
		$member['flat_id'] = $flat_id;
		return View::make('home.member',$member);			
	}

	public function post_member()
	{
		$input = Input::get();
		$residing = Input::get('residing') ? 1 : 0;
		// Get the relevant rules for validation
		$rules = IoC::resolve('member_validator');
		$validation = Validator::make($input, $rules);
		if ($validation->fails())
		{
		    return Redirect::back()->with_input()->with_errors($validation);
		}
		else
		{
			$member = new User();
			$member->name = Input::get('name');
			$member->email = Input::get('email');
			$member->save();
			
			$phone = new Phone(array('phone_no' => Input::get('phone_no')));
			
			$member->phones()->insert($phone);
			$member->houses()->attach(Input::get('flat_id'),array('relation' => Input::get('relation'),'residing' => $residing));			
			
			if(Session::has('back-url'))
			{
				$url = Session::get('back-url');
				Session::forget('back-url');
				return Redirect::to($url);
			}
			else
			{
				return Redirect::to('members');
			}
		}		

	}
	
	public function put_member($member_id)
	{
		$input = Input::get();
		$residing = Input::get('residing') ? 1 : 0;
		//Get the hidden flat id, if it exists
		$flat_id = Input::get('flat_id');
		// Get the relevant rules for validation
		$rules = IoC::resolve('member_validator',array('id' => $member_id));
		$validation = Validator::make($input, $rules);
		if ($validation->fails())
		{
		    return Redirect::back()->with_input()->with_errors($validation);
		}
		else
		{
			//Update the new information
			$member = User::with(array('phones'))->find($member_id);
			$member->name = Input::get('name');
			$member->email = Input::get('email');
			$member->save();
			
			$phone = $member->phones()->first();
			$phone->phone_no = Input::get('phone_no');
			$phone->save();
			
			if($flat_id)
			{
				//todo : prasanna : can be improved
				foreach($member->houses()->pivot()->get() as $row)
				{
					if ($row->house_id == $flat_id)
					{
						$row->relation = Input::get('relation');
						$row->residing = $residing;
						//$row->save();
						$row->save();
						break;
					}
				}
			}
			
			if(Session::has('back-url'))
			{
				$url = Session::get('back-url');
				Session::forget('back-url');
				return Redirect::to($url);
			}
			else
			{
				return Redirect::to('members');
			}
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
