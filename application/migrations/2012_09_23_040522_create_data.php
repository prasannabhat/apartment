<?php

class Create_Data {

	/**
	 * Make changes to the database.
	 *
	 * @return void
	 */
	public function up()
	{
		$user = new User;
		$user->name = 'Prasanna Bhat';
		$user->email = 'prasanna.yoga@gmail.com';
		$user->password = 'asdf';
		$user->save();

		$house = new House(array('house_no' => '11','floor' => 'D'));
		$house->save();
		$user->houses()->attach($house->id);

		$phone = new Phone(array('phone_no' => '9972010366'));
		$user->phones()->insert($phone);
		
		$user = User::create(array(
			'name' => 'Amruta Prasanna',
			'email' => 'amruta.pune@gmail.com',
			'password' => 'asdf'
		));
		$phone = new Phone(array('phone_no' => '9880362090'));
		$user->phones()->insert($phone);
		$user->houses()->attach($house->id);
	}

	/**
	 * Revert the changes to the database.
	 *
	 * @return void
	 */
	public function down()
	{
		$user = User::where('email', '=', 'prasanna.yoga@gmail.com')->first();
		$houses = $user->houses;
		foreach($houses as $house)
		{
			$house->delete();
		}
		$user->delete();
		$user = User::where('email', '=', 'amruta.pune@gmail.com')->first();
		$user->delete();
	}

}