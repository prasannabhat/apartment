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
		$regex = "/^[ABCDE]\d{1,2}/";
		$params = func_get_arg(0);
		if($params){
			$flat = $params[0];
			$flats = Config::get('apartment.floors');
			$flats = implode('', $flats );
			print "$flats\n";
			$pattern = "/^[$flats]\d{1,2}/i";
			print preg_match($pattern, $flat);
						
		}
		
		 
		

	}


}