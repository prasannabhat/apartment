<?php

class Create_Data {

	/**
	 * Make changes to the database.
	 *
	 * @return void
	 */
	public function up()
	{
		$id = DB::table('users')->insert_get_id(array(
			'name' => 'Prasanna Bhat',
			'email' => 'prasanna.yoga@gmail.com',
			'password' => Hash::make('asdf')
		));

		DB::table('phones')->insert(array(
			'phone_no' => '9880362090',
			'user_id' => $id
		));
	}

	/**
	 * Revert the changes to the database.
	 *
	 * @return void
	 */
	public function down()
	{
		DB::table('users')->where('email', '=', 'prasanna.yoga@gmail.com')->delete();
	}

}