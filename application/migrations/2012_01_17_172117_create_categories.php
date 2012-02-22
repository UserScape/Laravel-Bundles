<?php
/**
 * Create Categories
 *
 * A migration for creating the categories table.
 *
 * @license     http://www.opensource.org/licenses/mit MIT License
 * @copyright   UserScape, Inc. (http://userscape.com)
 * @author      UserScape Dev Team
 * @link        http://bundles.laravel.com
 * @package     Laravel-Bundles
 * @subpackage  Migrations
 * @filesource
 */
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

		DB::table('categories')->insert(array('title' => 'Authentication', 'uri' => 'authentication'));
		DB::table('categories')->insert(array('title' => 'Api', 'uri' => 'api'));
		DB::table('categories')->insert(array('title' => 'HTML/UI', 'uri' => 'html-ui'));
		DB::table('categories')->insert(array('title' => 'Database', 'uri' => 'database'));
		DB::table('categories')->insert(array('title' => 'Security', 'uri' => 'security'));
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