<?php
/**
 * Create Pages
 *
 * A migration for creating a pages table to handle page content.
 *
 * @license     http://www.opensource.org/licenses/mit MIT License
 * @copyright   UserScape, Inc. (http://userscape.com)
 * @author      UserScape Dev Team
 * @link        http://bundles.laravel.com
 * @package     Laravel-Bundles
 * @subpackage  Migrations
 * @filesource
 */
 class Pages {

	/**
	 * Make changes to the database.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('pages', function($table)
		{
			$table->create();
			$table->increments('id');
			$table->string('title');
			$table->string('uri');
			$table->string('keywords');
			$table->text('content');
			$table->integer('parent');
			$table->integer('order');
			$table->string('nav', 1)->default('y');
			$table->timestamps();
			$table->index('order');
			$table->index('parent');
		});
	}

	/**
	 * Revert the changes to the database.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('pages', function($table)
		{
			$table->drop();
		});
	}
}