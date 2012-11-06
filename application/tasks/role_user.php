<?php

class Role_User_Task {
		
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
	
	public function run($arguments){
		// command line arguments
		$params = self::get_params(func_get_arg(0));
		print_r($params);
		
	}
	
	public function add_user_roles($arguments){
		// command line arguments
		$params = self::get_params(func_get_arg(0));
		
		$role_power = Role::where('role','=','power')->first();		
		$role_user = Role::where('role','=','user')->first();
		$role_guest = Role::where('role','=','guest')->first();
		$role_super = Role::where('role','=','super')->first();
		
		$user = User::where('email','=','prasanna.yoga@gmail.com')->first();
		$user->password = "asdf";
		$user->save();
		$user->roles()->delete();
		$user->roles()->sync(array($role_super->id));
		
		$user = User::where('email','=','amruta.pune@gmail.com')->first();
		$user->password = "asdf";
		$user->save();
		$user->roles()->delete();
// 		Make power user
		$user->roles()->sync(array($role_power->id));
		
		$user = User::where('email','=','bs.guru@gmail.com')->first();
		$user->password = "asdf";
		$user->save();
		$user->roles()->delete();
		// Make regular user
		$user->roles()->sync(array($role_user->id));
		
		$user = User::where('email','=','snbhat@gmail.com')->first();
		$user->password = "asdf";
		$user->save();
		$user->roles()->delete();
		// Make regular user
		$user->roles()->sync(array($role_guest->id));

		
		
		print "end\n";
	}
	
	public function check_role($arguments)
	{
		// command line arguments
		$params = self::get_params(func_get_arg(0));
		if($params['email'])
		{
			$user = User::where('email', '=' , $params['email'])->first();
			if($user){
				if($user->is("power")){
					print "user is admin";
				}
				else{
					print "user is not admin";
				}
				
			}
			else{
				print "given user not found\n";
			}
			
		}
		else {
			print "give email";

		}
		
	}

	public function admin($arguments)
	{
		$user = Auth::user();
		print "Logged in user is " . $user->name;
	}
	
}