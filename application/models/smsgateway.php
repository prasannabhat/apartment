<?php

class SmsGateway extends Eloquent{
    
    public static $table = 'sms_gateway';
    public static $timestamps = false;
    public static $hidden = array('user_id');

    public function user()
    {
         return $this->belongs_to('User');
    }

    public function validate()
    {
    	$name_rule = sprintf('required|in:%s',implode(",", Config::get('apartment.allowed_gateways')));
		$rules = array(
			'name' => $name_rule,
			// Should match a phone number
			'user' => 'required|match:"/^\d{10}\s*$/"',
			'code' => 'required'
		);
    	$validation = Validator::make($this->to_array(), $rules);
    	return $validation;
    }
}