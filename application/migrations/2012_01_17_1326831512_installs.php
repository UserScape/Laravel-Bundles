<?php
/**
 * Create Installs
 *
 * A migration for creating an installs table. This will be used
 * for reporting and seeing which bundles are installed the most.
 *
 * @license     http://www.opensource.org/licenses/mit MIT License
 * @copyright   UserScape, Inc. (http://userscape.com)
 * @author      UserScape Dev Team
 * @link        http://bundles.laravel.com
 * @package     Laravel-Bundles
 * @subpackage  Migrations
 * @filesource
 */
class Installs {

	/**
	 * Make changes to the database.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('installs', function($table)
		{
			$table->create();
			$table->increments('id');
			$table->integer('bundle_id');
			$table->timestamps();
			$table->index('bundle_id');
		});
	}

	/**
	 * Revert the changes to the database.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('installs', function($table)
		{
			$table->drop();
		});
	}

}