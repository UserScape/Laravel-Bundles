<?php

class Create_Bundles {

	/**
	 * Make changes to the database.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('bundles', function($table)
		{
			$table->create();
			$table->increments('id');
			$table->string('title');
			$table->string('uri');
			$table->string('summary', 255);
			$table->text('description');
			$table->string('website', 255);
			$table->string('clone_url', 255);
			$table->string('provider', 255);
			$table->timestamps();
			$table->integer('category_id');
			$table->integer('user_id');
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
			$table->drop();
		});
	}

}