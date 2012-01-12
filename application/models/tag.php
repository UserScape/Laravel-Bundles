<?php
class Tag extends Eloquent\Model {

	public static $table = 'tags';

	public function bundles()
	{
		return $this->has_many('Listing');
	}

	public function save_tags($id, $tags)
	{
		// First remove old
		$affected = DB::table('bundle_tags')->where('bundle_id', '=', $id)->delete();

		if ( ! is_array($tags))
		{
			return FALSE; // No tags
		}

		foreach ($tags AS $key => $tag)
		{
			$tag_id = $this->add_tag($tag);
			$data = array('tags_tag_id' => $tag_id, 'tags_media_id' => $id);
			$this->db->insert('media_tags', $data);
		}

		return TRUE;
	}

	public function add_tag($tag)
	{
		$tag_check = parent::where('tag', '=', $tag)->first();

		var_dump($tag_check);die;
		$this->db->from('tags')->where('tag', $tag);
		$query = $this->db->get();

		if ($query->num_rows() > 0)
		{
			$row = $query->row();
			return $row->id;
		}

		$this->db->insert('tags', array('tag' => $tag));

		return $this->db->insert_id();
	}
}