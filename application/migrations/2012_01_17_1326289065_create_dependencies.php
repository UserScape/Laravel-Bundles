<?php

class Create_Dependencies {

	/**
	 * Make changes to the database.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('dependencies', function($table)
		{
			$table->create();
			$table->increments('id');
			$table->integer('bundle_id');
			$table->integer('dependency_id');
		});
	}

	/**
	 * Revert the changes to the database.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('dependencies', function($table)
		{
			$table->drop();
		});
	}

}