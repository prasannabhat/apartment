<?php

class TestModels extends PHPUnit_Framework_TestCase {

	/**
	 * Test that a given condition is met.
	 *
	 * @return void
	 */
	const NO_USER_ENTRIES = 100; 
	const TEST_USER = "Test User";
	const TEST_HOUSE = "Test House";
	const TEST_PHONE_NUMBER = "1234567890";
	private static $pattern;
	//some update in the test comment

	function __construct()
	{
		self::$pattern = '/^' . self::TEST_USER . '/';

	}

	private function delete_test_users()
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
	}

	private function add_test_users($count = self::NO_USER_ENTRIES)
	{
		//Add specified no of users
		for ($i = 0; $i < $count; $i++)
		{
			$user = new User;
			$user->name = self::TEST_USER . $i;
			$user->email = self::TEST_USER . $i . "@gmail.com";
			$user->password = "asdf";
			$user->save();
		}

	}

	private function delete_test_phones()
	{
		$phones = Phone::all();
		foreach ($phones as $phone)
		{
			// Delete all the test phone entries
			if(preg_match(self::$pattern, $phone->user->name))
			{
				$phone->delete();
			}
		}
	}
	
	private function add_test_houses($count = self::NO_USER_ENTRIES)
	{
		//Add specified no of houses
		for ($i = 0; $i < $count; $i++)
		{
			$house = new House;
			$house->house_no = self::TEST_HOUSE . $i;
			$house->save();
		}

	}	
	
	private function delete_test_houses()
	{
		$houses = House::all();
		foreach ($houses as $house)
		{
			// Delete all the test phone entries
			//if(preg_match(self::$pattern, $phone->user->name))
			{
				$house->delete();
			}
		}
	}

	public function testAddUsers()
	{
		//Delete any test data, if it exists
		$this->delete_test_users();
		$user_count = User::count();
		// Add some users
		$this->add_test_users();
		$this->assertTrue(($user_count + self::NO_USER_ENTRIES) == User::count());

	}

	/**
     * @depends testAddUsers
     */
	//Assumes that test users are added 
	public function testAddPhones()
	{
		// Delete test phone data
		$this->delete_test_phones();
		$phone_count = Phone::count();
		$test_user_count = 0;

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
				$test_user_count++;

			}
		}
		$this->assertTrue(($phone_count+ (2 * $test_user_count)) == Phone::count());
		return (2 * $test_user_count);
	}


	/**
     * @depends testAddPhones
     */
	//Assumes that test users & test phones are added 
	public function testPhoneCascadeDelete($testPhoneCount)
	{
		$total_phone_count = Phone::count();
		// Delete all the test users..This should automatically delete the phones due to cascade
		$this->delete_test_users();
		$this->assertTrue(($total_phone_count - $testPhoneCount) == Phone::count());
	}
	
	public function testAddHouses()
	{
		$this->delete_test_houses();
		$house_count = self::NO_USER_ENTRIES;
		$this->add_test_houses($house_count);
		$this->assertTrue($house_count == House::count());
	}
	
	/**
     * @depends testAddHouses
     */
	 //Assumes that the test house entries are already created
	public function testUserHouseRelation()
	{
		//Add some test users
		$this->add_test_users();
		$test_houses = House::where('house_no', 'like' , self::HOUSE . '%')->get();
		$test_users = User::where('name', 'like', self::TEST_USER . '%')->get();
		$test_house_size = count($test_houses);
		$index = 0;
		foreach($test_users as $user)
		{
			$user->houses()->attach($test_houses[$index]->id);
			$index++;
		}
		echo count($test_houses);
	}


}