<?php

class Create_Tags {

	/**
	 * Make changes to the database.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('listing_tags', function($table)
		{
			$table->create();
			$table->increments('id');
			$table->integer('tag_id');
			$table->integer('listing_id');
		});
		Schema::table('tags', function($table)
		{
			$table->create();
			$table->increments('id');
			$table->string('tag');
		});
	}

	/**
	 * Revert the changes to the database.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('listing_tags', function($table)
		{
			$table->drop();
		});
		Schema::table('tags', function($table)
		{
			$table->drop();
		});
	}

}