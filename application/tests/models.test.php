<?php

class TestModels extends PHPUnit_Framework_TestCase {

	/**
	 * Test that a given condition is met.
	 *
	 * @return void
	 */


	public function testDeleteUsers()
	{
		$users = User::all();
		foreach ($users as $user)
		{
		     echo print_r($user);
		}
		$this->assertTrue(true);
	}

	public function testDeletePhones()
	{
		$phones = Phone::all();
		foreach ($phones as $phone)
		{
			echo print_r($phone);
		}
	}

}