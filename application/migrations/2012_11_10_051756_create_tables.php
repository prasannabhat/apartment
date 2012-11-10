<?php

class Create_Tables {

	/**
	 * Make changes to the database.
	 *
	 * @return void
	 */
	public function up()
	{
		$connections = Config::get('database.connections');
		$connection = $connections[Config::get('database.default')];
		if($connection['driver'] == "mysql")
		{
			$con = mysql_connect($connection['host'], $connection['username'], $connection['password']);
			if (!$con)
			{
				die('Could not connect: ' . mysql_error());
			}
			mysql_select_db($connection['database'], $con);
			$query = "ALTER TABLE houses CHANGE block block VARCHAR(20) null;";
			mysql_query($query,$con);
			print "Migration successful\n";
			mysql_close($con);			
		}		
	}

	/**
	 * Revert the changes to the database.
	 *
	 * @return void
	 */
	public function down()
	{
		//
	}

}