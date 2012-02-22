<?php

class Bundleclass {

	/**
	 * Make changes to the database.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('listings', function($table)
		{
			$table->string('class')->default('');
		});
	}

	/**
	 * Revert the changes to the database.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('listings', function($table)
		{
			// $table->drop_key('index', 'active');
			$table->drop_column('class');
		});
	}

}