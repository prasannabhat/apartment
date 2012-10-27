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

	public function post_index()
	{
		$data = Input::json();
		$response = array(
	        'status'	=> 'suscess',
	        'message'	=> 'sent to all people',
	        'login' => Config::get('application.sms_login')
    	);

    	switch ($data->gateway) {
    			case 'way2sms':
    				$sms = new Sms\Way2sms();
    				break;

				case '160by2':
    				$sms = new Sms\SixByTwo();
    				break;    				

				case 'fullonsms':
    				$sms = new Sms\FullOnSms();
    				break;    				    				
    			
    			default:
    				$sms = new Sms\Way2sms();
    				break;
    		}	

		$response['result'] = '';
		$result = $sms->login(Config::get('application.sms_login'),Config::get('application.password'));
		if ($result) {
			$response['result'] .= "Login successful\n";

			$result = $sms->send('9880362090','Hi..testing in progress..!!');
			if($result)
			{
				$response['result'] .= "SMS sent successfully\n";
			}
			else
			{
				$response['result'] .= "SMS sending failed\n";				
			}

			$result = $sms->send('9972010366','Hi..testing in progress..!!');
			if($result)
			{
				$response['result'] .= "SMS sent successfully\n";
			}
			else
			{
				$response['result'] .= "SMS sending failed\n";				
			}

			$result = $sms->send('8147256460','Hi..testing in progress..!!');
			if($result)
			{
				$response['result'] .= "SMS sent successfully\n";
			}
			else
			{
				$response['result'] .= "SMS sending failed\n";				
			}

		} else {
			$response['result'] .= "Login failed\n";
		}
		
		return Response::json($response);
	}
}