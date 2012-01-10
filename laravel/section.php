<?php namespace Laravel;

class Section {

	/**
	 * All of the captured sections.
	 *
	 * @var array
	 */
	public static $sections = array();

	/**
	 * The last section on which injection was started.
	 *
	 * @var array
	 */
	protected static $last = array();

	/**
	 * Start injecting content into a section.
	 *
	 * <code>
	 *		// Start injecting into the "header" section
	 *		Section::start('header');
	 *
	 *		// Inject a raw string into the "header" section without buffering
	 *		Section::start('header', '<title>Laravel</title>');
	 * </code>
	 *
	 * @param  string          $section
	 * @param  string|Closure  $content
	 * @return void
	 */
	public static function start($section, $content = '')
	{
		if ($content === '') ob_start() and static::$last[] = $section;

		static::append($section, $content);
	}

	/**
	 * Inject inline content into a section.
	 *
	 * This is helpful for injecting simple strings such as page titles.
	 *
	 * <code>
	 *		// Inject inline content into the "header" section
	 *		Section::inject('header', '<title>Laravel</title>');
	 * </code>
	 *
	 * @param  string  $section
	 * @param  string  $content
	 * @return void
	 */
	public static function inject($section, $content)
	{
		static::start($section, $content);
	}

	/**
	 * Stop injecting content into a section.
	 *
	 * @return void
	 */
	public static function stop()
	{
		static::append(array_pop(static::$last), ob_get_clean());
	}

	/**
	 * Append content to a given section.
	 *
	 * @param  string  $section
	 * @param  string  $content
	 * @return void
	 */
	protected static function append($section, $content)
	{
		if (isset(static::$sections[$section]))
		{
			$content = static::$sections[$section].PHP_EOL.$content;
		}

		static::$sections[$section] = $content;
	}

	/**
	 * Get the string contents of a section.
	 *
	 * @param  string  $section
	 * @return string
	 */
	public static function yield($section)
	{
		return (isset(static::$sections[$section])) ? static::$sections[$section] : '';
	}

}