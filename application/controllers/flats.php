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
		return View::make('home.flat',array('flat_id' => $flat_id));			
	}

	public function post_flat()
	{
		$input = Input::get();
		
		// Get the relevant rules for validation
		$rules = IoC::resolve('validator');
		$validation = Validator::make($input, $rules);
		if ($validation->fails())
		{
		    $route = Apartment\Constants::ROUTE_FLAT;
		    return "$route\n";
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
		$house->house_no = $input['house_no'];
		$house->floor = $input['floor'];
		$house->save();
		return Redirect::to('flats');
	}

	public function delete_flat($flat_id)
	{
		$house = House::find($flat_id);
		$house->delete();
		return Redirect::to('flats');
	}
	
}