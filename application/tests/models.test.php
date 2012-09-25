<?php

class TestModels extends PHPUnit_Framework_TestCase {

	/**
	 * Test that a given condition is met.
	 *
	 * @return void
	 */
	const NO_USER_ENTRIES = 100; 
	const TEST_USER = "Test User";
	const TEST_PHONE_NUMBER = "1234567890";
	private static $prev_user_count;
	private static $prev_phone_count;
	private static $pattern;
	//some update in the test comment

	function __construct()
	{
		self::$pattern = '/^' . self::TEST_USER . '/';

	}
	public function testDeleteUsers()
	{
		$users = User::all();
		foreach ($users as $user)
		{
			// Delete all the test entries
			if(preg_match(self::$pattern, $user->name))
			{
				$user->delete();
			}
		}
		// Store the original no of entries
		self::$prev_user_count = User::count();
	}

	public function testDeletePhones()
	{
		$phones = Phone::all();
		foreach ($phones as $phone)
		{
			// Delete all the test entries
			if(preg_match(self::$pattern, $phone->user->name))
			{
				$phone->delete();
			}
			// Store the original no of entries
			self::$prev_phone_count = Phone::count();			
		}
	}

	/**
     * @depends testDeleteUsers
     */
	public function testAddUsers()
	{
		//Add specified no of users
		for ($i = 0; $i < self::NO_USER_ENTRIES ; $i++)
		{
			$user = new User;
			$user->name = self::TEST_USER . $i;
			$user->email = self::TEST_USER . $i . "@gmail.com";
			$user->password = "asdf";
			$user->save();
		}
		$this->assertTrue((self::$prev_user_count + self::NO_USER_ENTRIES) == User::count());
	}

	/**
     * @depends testDeletePhones
     */
	public function testAddPhones()
	{
		$users = User::all();
		foreach($users as $user)
		{
			// Add the phones to only test users
			if(preg_match(self::$pattern, $user->name))
			{
				//Insert two phone records per user
				$phones = array(
				    array('phone_no' => self::TEST_PHONE_NUMBER,'is_primary' => TRUE),
				    array('phone_no' => self::TEST_PHONE_NUMBER + 1),
				);
				$user->phones()->save($phones);

			}
		}
		$this->assertTrue((self::$prev_phone_count + (2 * self::NO_USER_ENTRIES)) == Phone::count());
	}

	/**
     * @depends testAddUsers
     * @depends testAddPhones
     */
	public function testDeleteUsersCascade()
	{

	}

}