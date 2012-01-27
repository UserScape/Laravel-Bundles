<?php
/**
 * Create Rating
 *
 * A migration for creating the ratings table.
 *
 * @license     http://www.opensource.org/licenses/mit MIT License
 * @copyright   UserScape, Inc. (http://userscape.com)
 * @author      UserScape Dev Team
 * @link        http://bundles.laravel.com
 * @package     Laravel-Bundles
 * @subpackage  Migrations
 * @filesource
 */
class Create_Rating {

	/**
	 * Make changes to the database.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('rating', function($table)
		{
			$table->create();
			$table->increments('id');
			$table->integer('listing_id');
			$table->integer('user_id');
			$table->string('ip_address');
			$table->timestamps();
		});
	}

	/**
	 * Revert the changes to the database.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('rating', function($table)
		{
			$table->drop();
		});
	}

}