<?php
namespace Apartment;

/**
* 
*/
class Utilities
{
	public static function get_validations($id) {
		\Log::info('id is ' . $id);
		$house_rule = sprintf('required|match:"/^[ABCDE]\d{1,2}/"|unique:houses,house_no,%s', $id);
		$rules = array(
			'house_no'  => $house_rule,
			'floor' => 'required|in:A,B,C,D,E'
		);
		return $rules;
    }
}
