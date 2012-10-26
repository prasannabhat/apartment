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
		$members = User::order_by('name','asc')->get();
		Session::put('back-url', URL::current());
		return View::make('home.members',array('members' => $members));
	}

	public function get_member($member_id = -1)
	{
		//Default array for creating a new member
		$member = array ( 'name' => '', 'email' => '', 'phone_no' => '', 'notes' => '');
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
				$member['notes'] = $user->notes;
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
		//Get the hidden flat id, if it exists
		$flat_id = Input::get('flat_id');
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
			$member->notes = Input::get('notes');
			$member->save();
			
			// Update the phone, if it is given
			if(Input::get('phone_no'))
			{
				$phone = new Phone(array('phone_no' => Input::get('phone_no')));
				$member->phones()->insert($phone);				
			}
			// Update flat relationship, only if it is supplied
			if($flat_id)
			{
				$member->houses()->attach(Input::get('flat_id'),array('relation' => Input::get('relation'),'residing' => $residing));
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
			$member->notes = Input::get('notes');
			$member->save();
			
			$phone = $member->phones()->first();
			// If phone already exists
			if($phone)
			{
				$phone->phone_no = Input::get('phone_no');
				$phone->save();				
			}
			else
			{
				$phone = new Phone(array('phone_no' => Input::get('phone_no')));
				$member->phones()->insert($phone);								
			}
			
			if($flat_id)
			{
				$pivot = HouseUser::where('user_id', '=' , $member_id)->where('house_id' , '=', $flat_id)->first();
				if($pivot)
				{
					// To overcome laravel bug, manually work with intermediate tables
					$pivot->relation = Input::get('relation');
					$pivot->residing = $residing;
					$pivot->save();
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

	public function delete_member($member_id)
	{
		$user = User::find($member_id);
		$user->delete();
		return Redirect::to('members');
	}

}
