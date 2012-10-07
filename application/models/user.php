<?php

class User extends Eloquent {

     public static $timestamps = true;

     public function phones()
     {
          return $this->has_many('Phone');
     }
	 
	 public function houses()
	 {
		return $this->has_many_and_belongs_to('House');
	 }

    public function roles()
     {
        return $this->has_many_and_belongs_to('Role');
     }     

     public function set_password($password)
     {
        $this->set_attribute('password', Hash::make($password));
     }

     private function check_role($user_role)
     {
        $roles = $this->roles;
        foreach ($roles as $role)
        {
            if($role->role == $user_role)
            {
                return true;
            }
        }
        return false;

     }

     public function is_admin()
     {
        return $this->check_role("admin");
     }

    public function is_user()
     {
        return $this->check_role("user");
     }     

    public function is_super()
     {
        return $this->check_role("super");
     }          

    public function is_guest()
     {
        return true;
     }               

}