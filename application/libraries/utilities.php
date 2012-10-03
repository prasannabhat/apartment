<?php

/**
* 
*/
class Utilities
{
	public static function get_validations() {
		$rules = array(
			'house_no'  => 'required|between:2,3',
			'floor' => 'required|alpha|size:1'
		);
		return $rules;
    }
}
