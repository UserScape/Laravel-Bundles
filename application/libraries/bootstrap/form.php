<?php namespace Bootstrap;

use \HTML;
use \ReflectionClass;

/**
 * Form generation geared around Bootstrap from Twitter.
 *
 * @author PhillS
 * @see http://twitter.github.com/bootstrap/
 */
class Form extends \Laravel\Form {

	/**
	 * Stacked, left-aligned labels over controls
	 */
	const TYPE_VERTICAL   = 'vertical-form';

	/**
	 * Float left, right-aligned labels on same line as controls
	 */
	const TYPE_HORIZONTAL = 'horizontal-form';

	/**
	 * Left-aligned label and inline-block controls for compact style
	 */
	const TYPE_INLINE     = 'inline-form';

	/**
	 * Extra-rounded text input for a typical search aesthetic
	 */
	const TYPE_SEARCH     = 'search-form';

	/**
	 * Create a HTML form field.
	 *
	 * <code>
	 *     echo Form::field('text', 'name', 'Your name', array('Phill'), array('help' => 'Your full name', 'error' => true));
	 * </code>
	 *
	 * @param string $type  Any {@link Laravel\Form} method with $name as the first parameter.
	 * @param string $name  The name of the HTML field.
	 * @param string $label A HTML label for this field.
	 * @param array  $args  Additional parameters passed in order to the Form method.
	 * @param array  $opts  Additional form field parameters; help, error, warning or success.
	 * @return string
	 */
	public static function field($type, $name, $label, array $args = array(), array $opts = array())
	{
		$opts = array_filter($opts); // remove false, 0, '', null values

		// Add error classes to the fieldset if present in the opts
		$class = array_intersect(array('error', 'warning', 'success'), array_keys($opts));
		$class = trim('control-group '.implode(' ', $class));

		// Name is always the first argument passed to form fields
		array_unshift($args, $name);

		// Build the HTML
		$out  = '<fieldset class="'.$class.'">';
		if ( ! empty($label))
		{
			$out .= Form::label($name, $label, array('class' => 'control-label'));
		}
		$out .= '<div class="controls">'.PHP_EOL;
		$out .= forward_static_call_array(array('Form', $type), $args);
		foreach (array('error', 'warning', 'success') as $key)
		{
			if ( ! empty($opts[$key]) and is_string($opts[$key]))
			{
				// @todo this should be 'help-block' for vertical forms
				$out .= '<span class="help-inline">'. $opts[$key] .'</span>';
			}
		}
		if ( ! empty($opts['help']))
		{
			$out .= '<p class="help-text">'. $opts['help'] .'</p>';
		}
		$out .= '</div>'; // div.controls
		$out .= '</fieldset>'.PHP_EOL;

		return $out;
	}

	/**
	 * @param string $label
	 * @param array  $fields
	 * @param array  $opts
	 * @return string
	 */
	public static function field_list($label, array $fields = array(), array $opts = array())
	{
		$opts = array_filter($opts); // remove false, 0, '', null values

		// Add error classes to the fieldset if present in the opts
		$class = array_intersect(array('error', 'warning', 'success'), array_keys($opts));
		$class = trim('control-group '.implode(' ', $class));

		// Build the HTML
		$out  = '<fieldset class="'.$class.'">';
		if ( ! empty($label))
		{
			$out .= Form::label('', $label, array('class' => 'control-label'));
		}
		$out .= '<div class="controls"><div class="control-list">'.PHP_EOL;
		$out .= implode('', $fields);
		foreach (array('error', 'warning', 'success') as $key)
		{
			if ( ! empty($opts[$key]) and is_string($opts[$key]))
			{
				// @todo this should be 'help-inline' for vertical forms
				$out .= '<p class="help-block">'. $opts[$key] .'</p>';
			}
		}
		if ( ! empty($opts['help']))
		{
			$out .= '<p class="help-text">'. $opts['help'] .'</p>';
		}
		$out .= '</div></div>'; // div.control-list div.controls
		$out .= '</fieldset>';

		return $out;
	}

	/**
	 * Create a HTML checkbox input element with a label.
	 *
	 * <code>
	 *		// Create a labelled checkbox element that is selected by default
	 *		echo Form::checkbox('Remember my details', 'remember', 'yes', true);
	 * </code>
	 *
	 * @see Laravel\Form::checkbox()
	 * @param  string  $label
	 * @param  string  $name
	 * @param  string  $value
	 * @param  bool    $checked
	 * @param  array   $attributes
	 * @return string
	 */
	public static function labelled_checkbox($name, $label, $value = 1, $checked = false, $attributes = array())
	{
		$args = func_get_args();
		array_splice($args, 1, 1); // Remove $label

		return '<label class="checkbox">'.forward_static_call_array(array('Form', 'checkbox'), $args).' '.$label.'</label>'.PHP_EOL;
	}

	/**
	 * Create a group of form actions (buttons).
	 *
	 * @param  mixed  $buttons  String or array of HTML buttons.
	 * @return string
	 */
	public static function actions($buttons)
	{
		$out  = '<fieldset class="form-actions">';
		$out .= is_array($buttons) ? implode('', $buttons) : $buttons;
		$out .= '</fieldset>';

		return $out;
	}


	/**
	 * Create a HTML submit input element.
	 *
	 * @param  string  $value
	 * @param  array   $attributes
	 * @return string
	 */
	public static function submit($value, $attributes = array())
	{
		$attributes['type'] = 'submit';
		$attributes['class'] .= ' btn';

		return static::button($value, $attributes);
	}

	/**
	 * Create a HTML reset input element.
	 *
	 * @param  string  $value
	 * @param  array   $attributes
	 * @return string
	 */
	public static function reset($value, $attributes = array())
	{
		$attributes['type'] = 'reset';
		$attributes['class'] .= ' btn';
		return static::button($value, $attributes);
	}

}