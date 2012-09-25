<?php

class TestModels extends PHPUnit_Framework_TestCase {

	/**
	 * Test that a given condition is met.
	 *
	 * @return void
	 */
	const NO_USER_ENTRIES = 100; 
	//some update in the test comment

	public function testDeleteUsers()
	{
		$users = User::all();
		foreach ($users as $user)
		{
			if($user->email == "prasanna.yoga@gmail.com")
			{
				echo "Found Prasanna\n";
			}
			else
			{
				$user->delete();
			}
		}
		$this->assertTrue(true);
	}

	public function testDeletePhones()
	{
		$phones = Phone::all();
		foreach ($phones as $phone)
		{
			if($phone->user->email == "prasanna.yoga@gmail.com")
			{
				echo "Found prasanna's phone\n";
			}
			else
			{
				$phone->delete();
			}
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
			$user->email = "amruta.pune@gmail.com" . $i;
			$user->name = "Amruta Prasanna" . $i;
			$user->save();
		}
		$this->assertTrue((self::NO_USER_ENTRIES + 1) == User::count());

	}

}