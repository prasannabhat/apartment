<?php

class HouseUser extends Eloquent {

    public static $table = 'house_user';
    public static $timestamps = true;
	
	public function get_relation()
	{
		return $this->relation  . "yes";
	}
         

}