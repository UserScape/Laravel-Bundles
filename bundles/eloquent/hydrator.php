<?php namespace Eloquent;

class Hydrator {

	/**
	 * Load the array of hydrated models and their eager relationships.
	 *
	 * @param  Model  $eloquent
	 * @return array
	 */
	public static function hydrate($eloquent)
	{
		$results = static::base(get_class($eloquent), $eloquent->query->get());

		if (count($results) > 0)
		{
			foreach ($eloquent->includes as $include)
			{
				if ( ! method_exists($eloquent, $include))
				{
					throw new \LogicException("Attempting to eager load [$include], but the relationship is not defined.");
				}

				static::eagerly($eloquent, $results, $include);
			}
		}

		return $results;
	}

	/**
	 * Hydrate the base models for a query.
	 *
	 * The resulting model array is keyed by the primary keys of the models.
	 * This allows the models to easily be matched to their children.
	 *
	 * @param  string  $class
	 * @param  array   $results
	 * @return array
	 */
	private static function base($class, $results)
	{
		$models = array();

		foreach ($results as $result)
		{
			$model = new $class;

			$model->attributes = (array) $result;

			$model->exists = true;

			$pk = Model::pk($class);

			if (isset($model->attributes[$pk]))
			{
				$models[$model->$pk] = $model;
			}
			else
			{
				$models[] = $model;
			}
		}

		return $models;
	}

	/**
	 * Eagerly load a relationship.
	 *
	 * @param  object  $eloquent
	 * @param  array   $parents
	 * @param  string  $include
	 * @return void
	 */
	private static function eagerly($eloquent, &$parents, $include)
	{
		// We temporarily spoof the query attributes to allow the query to be fetched without
		// any problems, since the belongs_to method actually gets the related attribute.
		$first = reset($parents);

		$eloquent->attributes = $first->attributes;

		$relationship = $eloquent->$include();

		$eloquent->attributes = array();

		// Reset the WHERE clause and bindings on the query. We'll add our own WHERE clause soon.
		// This will allow us to load a range of related models instead of only one.
		$relationship->query->reset_where();

		// Initialize the relationship attribute on the parents. As expected, "many" relationships
		// are initialized to an array and "one" relationships are initialized to null.
		foreach ($parents as &$parent)
		{
			$parent->ignore[$include] = (in_array($eloquent->relating, array('has_many', 'has_and_belongs_to_many'))) ? array() : null;
		}

		if (in_array($relating = $eloquent->relating, array('has_one', 'has_many', 'belongs_to')))
		{
			return static::$relating($relationship, $parents, $eloquent->relating_key, $include);			
		}
		else
		{
			static::has_and_belongs_to_many($relationship, $parents, $eloquent->relating_key, $eloquent->relating_table, $include);
		}
	}

	/**
	 * Eagerly load a 1:1 relationship.
	 *
	 * @param  object  $relationship
	 * @param  array   $parents
	 * @param  string  $relating_key
	 * @param  string  $relating
	 * @param  string  $include
	 * @return void
	 */
	private static function has_one($relationship, &$parents, $relating_key, $include)
	{
		foreach ($relationship->where_in($relating_key, array_keys($parents))->get() as $key => $child)
		{
			$parents[$child->$relating_key]->ignore[$include] = $child;
		}
	}

	/**
	 * Eagerly load a 1:* relationship.
	 *
	 * @param  object  $relationship
	 * @param  array   $parents
	 * @param  string  $relating_key
	 * @param  string  $relating
	 * @param  string  $include
	 * @return void
	 */
	private static function has_many($relationship, &$parents, $relating_key, $include)
	{
		foreach ($relationship->where_in($relating_key, array_keys($parents))->get() as $key => $child)
		{
			$parents[$child->$relating_key]->ignore[$include][$child->{Model::pk(get_class($child))}] = $child;
		}
	}

	/**
	 * Eagerly load a 1:1 belonging relationship.
	 *
	 * @param  object  $relationship
	 * @param  array   $parents
	 * @param  string  $relating_key
	 * @param  string  $include
	 * @return void
	 */
	private static function belongs_to($relationship, &$parents, $relating_key, $include)
	{
		$keys = array();

		foreach ($parents as &$parent)
		{
			$keys[] = $parent->$relating_key;
		}

		$children = $relationship->where_in(Model::pk(get_class($relationship)), array_unique($keys))->get();

		foreach ($parents as &$parent)
		{
			if (array_key_exists($parent->$relating_key, $children))
			{
				$parent->ignore[$include] = $children[$parent->$relating_key];
			}
		}
	}

	/**
	 * Eagerly load a many-to-many relationship.
	 *
	 * @param  object  $relationship
	 * @param  array   $parents
	 * @param  string  $relating_key
	 * @param  string  $relating_table
	 * @param  string  $include
	 *
	 * @return void	
	 */
	private static function has_and_belongs_to_many($relationship, &$parents, $relating_key, $relating_table, $include)
	{
		// The model "has and belongs to many" method sets the SELECT clause; however, we need
		// to clear it here since we will be adding the foreign key to the select.
		$relationship->query->select = null;

		$relationship->query->where_in($relating_table.'.'.$relating_key, array_keys($parents));

		// The foreign key is added to the select to allow us to easily match the models back to their parents.
		// Otherwise, there would be no apparent connection between the models to allow us to match them.
		$children = $relationship->query->get(array(Model::table(get_class($relationship)).'.*', $relating_table.'.'.$relating_key));

		$class = get_class($relationship);

		foreach ($children as $child)
		{
			$related = new $class;

			$related->attributes = (array) $child;

			$related->exists = true;

			// Remove the foreign key since it was only added to the query to help match the models.
			unset($related->attributes[$relating_key]);

			$parents[$child->$relating_key]->ignore[$include][$child->{Model::pk($class)}] = $related;
		}
	}

}
