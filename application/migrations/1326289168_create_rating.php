<?php

class Create_Rating {

	/**
	 * Make changes to the database.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('rating', function($table)
		{
			$table->create();
			$table->increments('id');
			$table->integer('bundle_id');
			$table->integer('user_id');
			$table->string('ip_address');
			$table->timestamps();
		});
	}

	/**
	 * Revert the changes to the database.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('rating', function($table)
		{
			$table->drop();
		});
	}

}