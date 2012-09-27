<?php

class Create_Tables {

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
			$table->string('password', 64)->nullable();
			// created_at | updated_at DATETIME
			$table->timestamps();
			$table->engine = 'InnoDB';
		});


		Schema::create('phones', function($table) {
			// auto incremental id (PK)
			$table->increments('id');
			// varchar 32
			$table->string('phone_no', 15);
			$table->boolean('is_primary')->default(FALSE);
			$table->integer('user_id')->unsigned();
			// created_at | updated_at DATETIME
			$table->timestamps();

			$table->foreign('user_id')->references('id')->on('users')->on_update('cascade')->on_delete('cascade');
			$table->engine = 'InnoDB';
		});

		Schema::create('houses', function($table) {
			// auto incremental id (PK)
			$table->increments('id');
			// varchar 32
			$table->string('house_no', 10);

			// created_at | updated_at DATETIME
			$table->timestamps();

			$table->engine = 'InnoDB';
		});

		Schema::create('house_user', function($table) {
			// auto incremental id (PK)
			$table->increments('id');

			$table->integer('user_id')->unsigned();
			$table->integer('house_id')->unsigned();

			$table->integer('owner_type')->unsigned()->default(0);
			$table->integer('resident_type')->unsigned()->default(0);

			// created_at | updated_at DATETIME
			$table->timestamps();

			$table->foreign('user_id')->references('id')->on('users')->on_update('cascade')->on_delete('cascade');
			$table->foreign('house_id')->references('id')->on('houses')->on_update('cascade')->on_delete('cascade');

			$table->engine = 'InnoDB';
		});
	}

	/**
	 * Revert the changes to the database.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('house_user');
		Schema::drop('phones');
		Schema::drop('houses');
		Schema::drop('users');
	}

}