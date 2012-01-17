<?php

class Installs {

	/**
	 * Make changes to the database.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('installs', function($table)
		{
			$table->create();
			$table->increments('id');
			$table->integer('bundle_id');
			$table->timestamps();
			$table->index('bundle_id');
		});
	}

	/**
	 * Revert the changes to the database.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('installs', function($table)
		{
			$table->drop();
		});
	}

}