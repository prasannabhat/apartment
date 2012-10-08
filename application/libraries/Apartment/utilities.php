<?php
namespace Apartment;

/**
* 
*/
class Utilities
{
	public static function get_flat_validations($id) {
		\Log::info('id is ' . $id);
		$house_rule = sprintf('required|match:"/^[ABCDE]\d{1,2}/"|unique:houses,house_no,%s', $id);
		$rules = array(
			'house_no'  => $house_rule,
			'floor' => 'required|in:A,B,C,D,E'
		);
		return $rules;
    }

	public static function get_member_validations($id) {
		\Log::info('member id is ' . $id);
		$house_rule = sprintf('required|match:"/^[ABCDE]\d{1,2}/"|unique:houses,house_no,%s', $id);
		$rules = array(
			'name' => 'required|match:"/^\w[\w\s]+/"|between:5,50',
			'phone_no' => 'required|match:"/^\d{10}\s*$/"',
			'email' => 'email',
			'relation' => 'required'
		);
		return $rules;
    }    

	public static function start_app()
	{
		//Register some IoC containers
		\IoC::register('flat_validator', function($id = -1){
		    $rules = Utilities::get_flat_validations($id);
		    return $rules;
		});

		\IoC::register('member_validator', function($id = -1){
		    $rules = Utilities::get_member_validations($id);
		    return $rules;
		});		
	}
	

	public static function get_member_flat_relations()
	{
		$MEMBER_FLAT_RELATION = array("Owner" => "owner","Co Owner" => "co-owner", "Owner's Family" => "owners-family",
	    		"Tenant" => "tenant", "Tenant's Family" => "tenant-family");
		return $MEMBER_FLAT_RELATION;

	}    
}
