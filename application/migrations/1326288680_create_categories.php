<?php

class Create_Categories {

	/**
	 * Make changes to the database.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('categories', function($table)
		{
			$table->create();
			$table->increments('id');
			$table->string('title');
			$table->string('uri');
			$table->text('description');
		});
	}

	/**
	 * Revert the changes to the database.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('categories', function($table)
		{
			$table->drop();
		});
	}

}