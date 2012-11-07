<?php

class check_Task {

	private static function get_params($args)
	{
		// Form the parameter array key value pairs
		$params = array();
		foreach ($args as $key => $value) {
			$result = preg_split('/=/',$value);
			if(count($result)  == 2)
			{
				$params[$result[0]] = $result[1];
			}
		}
		return $params;		
	}
	
	public function run(){
		// command line arguments
		$params = self::get_params(func_get_arg(0));
		
		$apartment = Config::get('apartment.sms_gateways');
		$gateway = 'way2sms';
		// print_r (Config::get('apartment.sms_gateways')[$gateway]);
		print_r ($apartment[$gateway]['login']);
		
		

		
		print "Run with some methods please!!";
	}


}