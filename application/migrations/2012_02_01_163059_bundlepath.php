<?php

class Bundlepath {

	/**
	 * Make changes to the database.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('listings', function($table)
		{
			$table->string('path')->default('');
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
			$table->drop_column('path');
		});
	}
}