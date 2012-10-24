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
		$user->password = 'bangalore76$';
		$user->save();

		$role_admin = Role::create(array(
			'role' => 'admin'
		));
		$role_user = Role::create(array(
			'role' => 'user'
		));
		$role_guest = Role::create(array(
			'role' => 'guest'
		));
		$role_super = Role::create(array(
			'role' => 'super'
		));

		$user->roles()->attach($role_admin->id);
		$user->roles()->attach($role_super->id);

		$house = new House(array('house_no' => 'D11','floor' => 'D'));
		$house->save();
		$user->houses()->attach($house->id,array('relation' => 'owner'));
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
	}

}