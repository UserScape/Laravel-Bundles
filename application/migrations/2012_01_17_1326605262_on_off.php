<?php

class On_Off {

	/**
	 * Make changes to the database.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('bundles', function($table)
		{
			$table->string('active', 1)->default('y');
			$table->index('active');
		});
	}

	/**
	 * Revert the changes to the database.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('bundles', function($table)
		{
			// $table->drop_key('index', 'active');
			$table->drop_column('active');
		});
	}

}