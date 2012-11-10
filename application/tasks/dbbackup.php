<?php

class dbbackup_Task {

	private static function get_file_path($file="backup",$directory="application\dbbackup")
	{
		$path =  "$directory\\$file.sql";
		return $path;

	}
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
		$args  = func_get_arg(0);
		$params = self::get_params($args);
		$path = self::get_file_path();
		print $path;
		
		print "Run with some methods please!!";
	}

	public function backup(){
		// get the command line arguments and convert them to param array
		$params = self::get_params(func_get_arg(0));
		print_r ($params);

		// Database configurations
		$options = Config::get('database');
		// Choose the user database connection, if specified otherwise choose the default one
		$default = array_key_exists('db', $params) ? $params['db'] : $options['default'];
		$default_connection = $options['connections'][$default];
		$mysqlDatabaseName = $default_connection['database'];
		print "backip up db $mysqlDatabaseName\n";
		$mysqlUserName = $default_connection['username'];
		$mysqlPassword = $default_connection['password'];
		$mysqlHostName = $default_connection['host'];
		$file_path = array_key_exists('file', $params) ? self::get_file_path($params['file']) : self::get_file_path();
		print "Backing up to file $file_path\n";

		
		//DONT EDIT BELOW THIS LINE
		//Export the database and output the status to the page
		$command='mysqldump --opt -h' .$mysqlHostName .' -u' .$mysqlUserName .' -p' .$mysqlPassword .' ' .$mysqlDatabaseName .' > ' . $file_path;
		exec($command,$output,$worked);
		switch($worked){
		    case 0:
		        echo 'Database <b>' .$mysqlDatabaseName .'</b> successfully exported to <b>~/' . $file_path .'</b>';
		        break;
		    case 1:
		        echo 'There was a warning during the export of <b>' .$mysqlDatabaseName .'</b> to <b>~/' .$file_path .'</b>';
		        break;
		    case 2:
		        echo 'There was an error during export. Please check your values:<br/><br/><table><tr><td>MySQL Database Name:</td><td><b>' .$mysqlDatabaseName .'</b></td></tr><tr><td>MySQL User Name:</td><td><b>' .$mysqlUserName .'</b></td></tr><tr><td>MySQL Password:</td><td><b>NOTSHOWN</b></td></tr><tr><td>MySQL Host Name:</td><td><b>' .$mysqlHostName .'</b></td></tr></table>';
		        break;
		}
	}

	public function restore($arguments){
		// get the command line arguments and convert them to param array
		$params = self::get_params(func_get_arg(0));		
		print_r ($params);

		$options = Config::get('database');
		// Choose the user database connection, if specified otherwise choose the default one
		$default = array_key_exists('db', $params) ? $params['db'] : $options['default'];
		$default_connection = $options['connections'][$default];
		$mysqlDatabaseName = $default_connection['database'];
		print "restoring db $mysqlDatabaseName\n";
		$mysqlUserName = $default_connection['username'];
		$mysqlPassword = $default_connection['password'];
		$mysqlHostName = $default_connection['host'];
		$file_path = array_key_exists('file', $params) ? self::get_file_path($params['file']) : self::get_file_path();		
		print "Restoring from file $file_path\n";

		//DONT EDIT BELOW THIS LINE
		//Export the database and output the status to the page
		$command='mysql -h' .$mysqlHostName .' -u' .$mysqlUserName .' -p' .$mysqlPassword .' ' .$mysqlDatabaseName .' < ' . $file_path;
		exec($command,$output,$worked);
		switch($worked){
		    case 0:
		        echo 'Import file <b>' .$file_path .'</b> successfully imported to database <b>' . $mysqlDatabaseName .'</b>';
		        break;
		    case 1:
		        echo 'There was an error during import. Please make sure the import file is saved in the same folder as this script and check your values:<br/><br/><table><tr><td>MySQL Database Name:</td><td><b>' .$mysqlDatabaseName .'</b></td></tr><tr><td>MySQL User Name:</td><td><b>' .$mysqlUserName .'</b></td></tr><tr><td>MySQL Password:</td><td><b>NOTSHOWN</b></td></tr><tr><td>MySQL Host Name:</td><td><b>' .$mysqlHostName .'</b></td></tr><tr><td>MySQL Import Filename:</td><td><b>' .$file_path .'</b></td></tr></table>';
		        break;
		}		
		
	}

}