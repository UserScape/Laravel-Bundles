<?php
/**
 * Create Dependencies
 *
 * A migration for creating the dependencies table.
 *
 * @license     http://www.opensource.org/licenses/mit MIT License
 * @copyright   UserScape, Inc. (http://userscape.com)
 * @author      UserScape Dev Team
 * @link        http://bundles.laravel.com
 * @package     Laravel-Bundles
 * @subpackage  Migrations
 * @filesource
 */
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
			$table->integer('listing_id');
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