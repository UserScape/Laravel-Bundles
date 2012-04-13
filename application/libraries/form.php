<?php

use \HTML;
use \Input;
use \Session;

/**
 * Form Library
 *
 * Used to modify various form actions.
 *
 * @license     http://www.opensource.org/licenses/mit MIT License
 * @copyright   UserScape, Inc. (http://userscape.com)
 * @author      UserScape Dev Team
 * @link        http://bundles.laravel.com
 * @package     Laravel-Bundles
 * @subpackage  Libraries
 * @filesource
 */
class Form extends \Laravel\Form {

	/**
	 * Value
	 *
	 * Set the value of a form field
	 *
	 * @param string $name
	 * @param object $object
	 * @param mixed $field
	 * @param mixed $default
	 * @return string
	 */
	public static function value($name, &$object, $field = null, $default = null)
	{
		if ( ! $object)
		{
			return '';
		}
		$field = ($field ?: $name);
		return Input::old($name, ($object->$field ?: $default));
	}

	/**
	 * Create a HTML input element.
	 *
	 * <code>
	 *		// Create a "text" input element named "email"
	 *		echo Form::input('text', 'email');
	 *
	 *		// Create an input element with a specified default value
	 *		echo Form::input('text', 'email', 'example@gmail.com');
	 * </code>
	 *
	 * @param  string  $name
	 * @param  mixed   $value
	 * @param  array   $attributes
	 * @return string
	 */
	public static function input($type, $name, $value = null, $attributes = array())
	{
		// Any errors?
		$errors = Session::get('errors');

		if ($errors and $errors->has($name))
		{
			if (isset($attributes['class']))
			{
				$attributes['class'] .= ' error';
			}
			else
			{
				$attributes['class'] = 'error';
			}
		}

		if ( ! isset($attributes['id']))
		{
			$attributes['id'] = $name;
		}

		return parent::input($type, $name, $value, $attributes);
	}

	/**
	 * Create a HTML submit input element.
	 *
	 * @author PhillS
 	 * @see http://twitter.github.com/bootstrap/
	 * @param  string  $value
	 * @param  array   $attributes
	 * @return string
	 */
	public static function submit($value, $attributes = array())
	{
		$attributes['type'] = 'submit';
		$attributes['class'] = 'btn btn-primary';

		return static::input('submit', null, $value, $attributes);
	}

	/**
	 * Create a HTML reset input element.
	 *
	 * @author PhillS
 	 * @see http://twitter.github.com/bootstrap/
	 * @param  string  $value
	 * @param  array   $attributes
	 * @return string
	 */
	public static function reset($value, $attributes = array())
	{
		$attributes['type'] = 'reset';
		$attributes['class'] = 'btn';

		return static::input('reset', null, $value, $attributes);
	}

}