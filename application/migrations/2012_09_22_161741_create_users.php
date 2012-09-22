<?php

class Create_Users {

	/**
	 * Make changes to the database.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('users', function($table) {
			// auto incremental id (PK)
			$table->increments('id');
			// varchar 32
			$table->string('name', 100)->unique();
			$table->string('email', 320)->unique();
			$table->string('password', 64);
			// created_at | updated_at DATETIME
			$table->timestamps();
			$table->engine = 'InnoDB';
		});
		//
	}

	/**
	 * Revert the changes to the database.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('users');
	}

}