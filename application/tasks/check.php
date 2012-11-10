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
		$connections = Config::get('database.connections');
		$connection = $connections[Config::get('database.default')];
		if($connection['driver'] == "mysql")
		{
			print_r ($connection);
			$con = mysql_connect($connection['host'], $connection['username'], $connection['password']);
			if (!$con)
			{
				die('Could not connect: ' . mysql_error());
			}
			mysql_select_db($connection['database'], $con);
			$query = "ALTER TABLE houses CHANGE block block VARCHAR(20) null;";
			mysql_query($query,$con);
			mysql_close($con);			

		}
	
	}


}