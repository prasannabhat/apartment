<?php

class dbbackup_Task {
	public static $mysqlExportPath ='application\dbbackup\backup.sql';
	
	public function run($arguments){
		print "Run with some methods please!!";
	}

	public function backup($arguments){
		$options = Config::get('database');
		$default_connection = $options['connections'][$options['default']];
		$mysqlDatabaseName = $default_connection['database'];
		$mysqlUserName = $default_connection['username'];
		$mysqlPassword = $default_connection['password'];
		$mysqlHostName = $default_connection['host'];
		
		//DONT EDIT BELOW THIS LINE
		//Export the database and output the status to the page
		$command='mysqldump --opt -h' .$mysqlHostName .' -u' .$mysqlUserName .' -p' .$mysqlPassword .' ' .$mysqlDatabaseName .' > ' . self::$mysqlExportPath;
		exec($command,$output,$worked);
		switch($worked){
		    case 0:
		        echo 'Database <b>' .$mysqlDatabaseName .'</b> successfully exported to <b>~/' . self::$mysqlExportPath .'</b>';
		        break;
		    case 1:
		        echo 'There was a warning during the export of <b>' .$mysqlDatabaseName .'</b> to <b>~/' .$mysqlExportPath .'</b>';
		        break;
		    case 2:
		        echo 'There was an error during export. Please check your values:<br/><br/><table><tr><td>MySQL Database Name:</td><td><b>' .$mysqlDatabaseName .'</b></td></tr><tr><td>MySQL User Name:</td><td><b>' .$mysqlUserName .'</b></td></tr><tr><td>MySQL Password:</td><td><b>NOTSHOWN</b></td></tr><tr><td>MySQL Host Name:</td><td><b>' .$mysqlHostName .'</b></td></tr></table>';
		        break;
		}
	}

	public function restore($arguments){
		$options = Config::get('database');
		$default_connection = $options['connections'][$options['default']];
		$mysqlDatabaseName = $default_connection['database'];
		$mysqlUserName = $default_connection['username'];
		$mysqlPassword = $default_connection['password'];
		$mysqlHostName = $default_connection['host'];
		
		//DONT EDIT BELOW THIS LINE
		//Export the database and output the status to the page
		$command='mysql -h' .$mysqlHostName .' -u' .$mysqlUserName .' -p' .$mysqlPassword .' ' .$mysqlDatabaseName .' < ' . self::$mysqlExportPath;
		exec($command,$output,$worked);
		switch($worked){
		    case 0:
		        echo 'Import file <b>' .self::$mysqlExportPath .'</b> successfully imported to database <b>' . $mysqlDatabaseName .'</b>';
		        break;
		    case 1:
		        echo 'There was an error during import. Please make sure the import file is saved in the same folder as this script and check your values:<br/><br/><table><tr><td>MySQL Database Name:</td><td><b>' .$mysqlDatabaseName .'</b></td></tr><tr><td>MySQL User Name:</td><td><b>' .$mysqlUserName .'</b></td></tr><tr><td>MySQL Password:</td><td><b>NOTSHOWN</b></td></tr><tr><td>MySQL Host Name:</td><td><b>' .$mysqlHostName .'</b></td></tr><tr><td>MySQL Import Filename:</td><td><b>' .$mysqlImportFilename .'</b></td></tr></table>';
		        break;
		}		
		
	}

}