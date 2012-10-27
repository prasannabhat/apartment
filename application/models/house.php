<?php

class House extends Eloquent {

    public static $timestamps = true;
	
	 public function users()
	 {
		return $this->has_many_and_belongs_to('User')->with(array('relation','residing'));
	 }

	 public function get_owner()
	 {
	 	foreach($this->users as $user)
	 	{
			if($user->pivot->relation == 'owner')
			{
				return $user;
			}
		}
	 }

	 public function get_tenant()
	 {
	 	foreach($this->users as $user)
	 	{
			if($user->pivot->relation == 'tenant')
			{
				return $user;
			}
		}
	 }

	 public function get_tenants()
	 {
	 	return array_filter($this->users, function($user){
			 		$relation = $user->pivot->relation;
					$select = (($relation == 'tenant') || ($relation == 'tenant-family')) ? true : false;	 		
					return $select;
			 	});
	 }	 

	 public function get_resident()
	 {
	 	$owner = $this->owner;
	 	// Check if the owner is residing in the premises
	 	if(($owner) && ($owner->pivot->residing))
	 	{
	 		return $owner;
	 	}

	 	$tenant = $this->tenant;
	 	// Check if the tenant is residing in the premises
	 	if(($tenant) && ($tenant->pivot->residing))
	 	{
	 		return $tenant;
	 	}
	 }

	 public function get_residents()
	 {
	 	return array_filter($this->users, function($user){
			 		$residing = $user->pivot->residing;
					return $residing;
			 	});
	 }	 	 
}