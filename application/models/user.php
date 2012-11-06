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

     public function check_role($allowed_roles)
     {
        $user_roles = array_map(function($role){
			return $role->role;
		}, $this->roles);

		$matched_roles = array_intersect($user_roles, $allowed_roles);

		return count($matched_roles) > 0 ? true : false;

     }

     public function is_super()
     {
        $allowed_rules = array('super');
        return $this->check_role($allowed_rules );
     }
	 
     public function is_admin()
     {
     	$allowed_rules = array('admin','super');
        return $this->check_role($allowed_rules);
     }
	 
	public function is_power()
     {
     	$allowed_rules = array('admin','super','power');
        return $this->check_role($allowed_rules);
     }	 

    public function is_user()
     {
     	$allowed_rules = array('admin','super','power','user');
        return $this->check_role($allowed_rules);
     }     


    public function is_guest()
     {
        return true;
     }               

}