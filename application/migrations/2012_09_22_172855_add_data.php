<?php

class Add_Data {

	/**
	 * Make changes to the database.
	 *
	 * @return void
	 */
	public function up()
	{
		DB::table('users')->insert(array(
		'name' => 'Prasanna Bhat',
		'email' => 'prasanna.yoga@gmail.com',
		'password' => Hash::make('asdf')
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