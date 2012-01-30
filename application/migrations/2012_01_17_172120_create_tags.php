<?php
/**
 * Create Tags
 *
 * A migration for creating the tags table.
 *
 * @license     http://www.opensource.org/licenses/mit MIT License
 * @copyright   UserScape, Inc. (http://userscape.com)
 * @author      UserScape Dev Team
 * @link        http://bundles.laravel.com
 * @package     Laravel-Bundles
 * @subpackage  Migrations
 * @filesource
 */
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