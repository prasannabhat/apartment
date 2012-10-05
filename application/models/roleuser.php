<?php

class RoleUser extends Eloquent {

    public static $table = 'role_user';
    public static $timestamps = true;

	public function users()
	{
		return $this->has_many_and_belongs_to('User');
	}    
         

}