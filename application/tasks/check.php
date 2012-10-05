<?php

class check_Task {
	
	public function run($arguments){
		$user = User::where('email', '=', $arguments[0])->first();
		print ("User name is " . $user->name . "\n");
		print $user->is_admin();
	}

	public function admin($arguments)
	{
		$user = Auth::user();
		print "Logged in user is " . $user->name;
	}
	
}