<?php

class User extends Eloquent {

     public static $timestamps = true;
	 public static $hidden = array('password');

     public function phones()
     {
          return $this->has_many('Phone');
     }
	 
	 public function houses()
	 {
		return $this->has_many_and_belongs_to('House')->with(array('relation','residing'));
	 }

    public function roles()
     {
        return $this->has_many_and_belongs_to('Role');
     }     

     public function set_password($password)
     {
        $this->set_attribute('password', Hash::make($password));
     }

     public function get_phone()
     {
		$phone = $this->phones()->first();
		if($phone)
		{
			return $phone->phone_no;
		}
     }
	 
	 public function get_flat_relation()
	 {
		if($this->pivot)
		{
			//Get the readable string of the relationship
			$relation_map = Apartment\Utilities::get_member_flat_relations();
			$key = array_search($this->pivot->relation, $relation_map); 
			return $key;
		}
	 }
	 
	 public function get_residing()
	 {
		if($this->pivot)
		{
			return ($this->pivot->residing) ? "Yes" : "No";
		}
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