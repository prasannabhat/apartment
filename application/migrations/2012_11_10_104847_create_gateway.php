<?php

class Create_Gateway {

	/**
	 * Make changes to the database.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('sms_gateway', function($table) {
			// auto incremental id (PK)
			$table->increments('id');
			// varchar 32
			// gateway name
			$table->string('name', 20);
			// user name for the gateway
			$table->string('user', 20);
			$table->string('code', 20);
			$table->integer('type')->unsigned();
			$table->text('notes');
			$table->integer('user_id')->unsigned();

			$table->foreign('user_id')->references('id')->on('users')->on_update('cascade')->on_delete('cascade');			
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
		Schema::drop('sms_gateway');
	}

}