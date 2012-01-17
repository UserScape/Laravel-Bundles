<?php
class Tag extends Eloquent\Model {

	public static $table = 'tags';

	public static $per_page = 1;

	/**
	 * Get bundles by tag
	 */
	public function bundles()
	{
		return $this->has_and_belongs_to_many('Listing', 'listing_tags', null, 'listing_id');
	}

	/**
	 * Save tags
	 *
	 * Saves the tags for a bundle
	 *
	 * @param int $id
	 * @param array $tags
	 * @return bool
	 */
	public function save_tags($id, $tags)
	{
		// First remove any existing tags for this bundle
		DB::table('listing_tags')->where('listing_id', '=', $id)->delete();

		if ( ! is_array($tags))
		{
			return false; // No tags
		}

		foreach ($tags AS $key => $tag)
		{
			$tag_id = $this->add_tag($tag);
			$data = array('tag_id' => $tag_id, 'listing_id' => $id);
			DB::table('listing_tags')->insert($data);
		}

		return true;
	}

	/**
	 * Add tag
	 *
	 * Adds a new tag if an existing one is not found.
	 *
	 * @param string $tag
	 * @return int id
	 */
	public function add_tag($tag)
	{
		$tag_check = static::query('Tag')->where('tag', '=', $tag)->first();

		if ( ! is_null($tag_check))
		{
			return $tag_check->id;
		}

		$tag = new static(array('tag' => $tag));

		$tag->save();

		return $tag->id;
	}
}