<?php

class Bundle_Controller extends Controller {

	public $restful = true;

	protected $categories = array();

	public function __construct()
	{
		Asset::add('jquery-tags', 'js/jquery.tagit.js', array('jquery','jquery-ui'));
		// Get the categories
		$cats = Category::all();
		foreach ($cats as $cat)
		{
			$this->categories[$cat->id] = $cat->title;
		}
	}

	public function get_add()
	{
		// Get the tags
		// This will not be used here. But on the edit page.
		/*
		$tag_query = Tag::where('tag', 'like', Input::get('term').'%')->get();
		$tags = array();
		foreach ($tag_query as $key => $tag)
		{
			$tags[$key] = $tag->tag;
		}

		return View::make('layouts.default')
			->nest('content', 'bundles.add')
			->with('tags', $tags);
		*/
		return View::make('layouts.default')
			->nest('content', 'bundles.add', array(
				'categories' => $this->categories
			));
	}

	public function post_add()
	{
		Input::flash();
		$rules = array(
			'location'     => 'required|url',
			'title'        => 'required|max:200|unique:bundles',
			'summary'      => 'required',
			'description'  => 'required',
			'website'      => 'url',
			'provider'     => '',
			'category_id'  => 'required'
		);

		$validator = Validator::make(Input::all(), $rules);

		if ($validator->invalid())
		{
			return Redirect::to('bundle/add')->with_errors($validator);
		}

		if ($depends = Input::get('dependencies'))
		{
			$dependencies = array();
			foreach ($depends as $bundle)
			{
				var_dump($bundle);
				//DB::table('dependencies')->insert(array('bundle_id' => $listing->id, 'dependency_id' => $bundle->id));
			}
		}
		die;

		$title = Input::get('title');

		$listing = new Listing;
		$listing->title = $title;
		$listing->summary = Input::get('summary');
		$listing->description = Input::get('description');
		$listing->website = Input::get('website');
		$listing->location = Input::get('location');
		$listing->provider = Input::get('provider', 'github');
		$listing->category_id = Input::get('category_id', 1);
		$listing->user_id = 1;
		$listing->uri = Str::slug($title, '_');
		$listing->save();

		// Now save tags
		$tag = new Tag;
		$tag->save_tags($listing->id, Input::get('tags'));

		// Now save dependencies
		// @todo - This is nasty. Has to be a cleaner way.
		// @todo - Also need to get the id by its title.
		if ($depends = Input::get('dependencies'))
		{
			$dependencies = array();
			foreach ($depends as $bundle)
			{
				DB::table('dependencies')->insert(array('bundle_id' => $listing->id, 'dependency_id' => $bundle->id));
			}
		}

		var_dump($listing->id);die;
	}

	/**
	 * Bundle detail page
	 *
	 * @param string item
	 * @return string view
	 */
	public function get_detail($item = '')
	{
		if ($item == '')
		{
			return Response::error('404');
		}

		$bundle = Listing::find($item);
		return View::make('layouts.default')
			->nest('content', 'bundles.detail', array(
				'bundle' => $bundle
			));
	}
}