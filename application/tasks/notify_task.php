<?php

class Notify_Task {
	
	public function run($arguments){
		$users = User::all();
		foreach ($users as $user)
		{
		     echo print_r($user);
		}

	}
	
}