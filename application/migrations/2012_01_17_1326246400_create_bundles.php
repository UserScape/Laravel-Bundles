<?php
/**
 * Create Bundles
 *
 * A migration for creating the bundle table.
 *
 * @license     http://www.opensource.org/licenses/mit MIT License
 * @copyright   UserScape, Inc. (http://userscape.com)
 * @author      UserScape Dev Team
 * @link        http://bundles.laravel.com
 * @package     Laravel-Bundles
 * @subpackage  Migrations
 * @filesource
 */
 class Create_Bundles {

	/**
	 * Make changes to the database.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('listings', function($table)
		{
			$table->create();
			$table->increments('id');
			$table->string('title');
			$table->string('uri');
			$table->string('summary', 255);
			$table->text('description');
			$table->string('website', 255);
			$table->string('location', 255);
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
		Schema::table('listings', function($table)
		{
			$table->drop();
		});
	}

}