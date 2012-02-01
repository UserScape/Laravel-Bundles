<?php namespace Laravel; use Closure, FilesystemIterator;

class File {

	/**
	 * Determine if a file exists.
	 *
	 * @param  string  $path
	 * @return bool
	 */
	public static function exists($path)
	{
		return file_exists($path);
	}

	/**
	 * Get the contents of a file.
	 *
	 * <code>
	 *		// Get the contents of a file
	 *		$contents = File::get(path('app').'routes'.EXT);
	 *
	 *		// Get the contents of a file or return a default value if it doesn't exist
	 *		$contents = File::get(path('app').'routes'.EXT, 'Default Value');
	 * </code>
	 *
	 * @param  string  $path
	 * @param  mixed   $default
	 * @return string
	 */
	public static function get($path, $default = null)
	{
		return (file_exists($path)) ? file_get_contents($path) : value($default);
	}

	/**
	 * Write to a file.
	 *
	 * @param  string  $path
	 * @param  string  $data
	 * @return int
	 */
	public static function put($path, $data)
	{
		return file_put_contents($path, $data, LOCK_EX);
	}

	/**
	 * Append to a file.
	 *
	 * @param  string  $path
	 * @param  string  $data
	 * @return int
	 */
	public static function append($path, $data)
	{
		return file_put_contents($path, $data, LOCK_EX | FILE_APPEND);
	}

	/**
	 * Delete a file.
	 *
	 * @param  string  $path
	 * @return void
	 */
	public static function delete($path)
	{
		if (static::exists($path)) @unlink($path);
	}

	/**
	 * Extract the file extension from a file path.
	 * 
	 * @param  string  $path
	 * @return string
	 */
	public static function extension($path)
	{
		return pathinfo($path, PATHINFO_EXTENSION);
	}

	/**
	 * Get the file type of a given file.
	 *
	 * @param  string  $path
	 * @return string
	 */
	public static function type($path)
	{
		return filetype($path);
	}

	/**
	 * Get the file size of a given file.
	 *
	 * @param  string  $file
	 * @return int
	 */
	public static function size($path)
	{
		return filesize($path);
	}

	/**
	 * Get the file's last modification time.
	 *
	 * @param  string  $path
	 * @return int
	 */
	public static function modified($path)
	{
		return filemtime($path);
	}

	/**
	 * Get a file MIME type by extension.
	 *
	 * <code>
	 *		// Determine the MIME type for the .tar extension
	 *		$mime = File::mime('tar');
	 *
	 *		// Return a default value if the MIME can't be determined
	 *		$mime = File::mime('ext', 'application/octet-stream');
	 * </code>
	 *
	 * @param  string  $extension
	 * @param  string  $default
	 * @return string
	 */
	public static function mime($extension, $default = 'application/octet-stream')
	{
		$mimes = Config::get('mimes');

		if ( ! array_key_exists($extension, $mimes)) return $default;

		return (is_array($mimes[$extension])) ? $mimes[$extension][0] : $mimes[$extension];
	}

	/**
	 * Determine if a file is a given type.
	 *
	 * The Fileinfo PHP extension is used to determine the file's MIME type.
	 *
	 * <code>
	 *		// Determine if a file is a JPG image
	 *		$jpg = File::is('jpg', 'path/to/file.jpg');
	 *
	 *		// Determine if a file is one of a given list of types
	 *		$image = File::is(array('jpg', 'png', 'gif'), 'path/to/file');
	 * </code>
	 *
	 * @param  array|string  $extension
	 * @param  string        $path
	 * @return bool
	 */
	public static function is($extensions, $path)
	{
		$mimes = Config::get('mimes');

		$mime = finfo_file(finfo_open(FILEINFO_MIME_TYPE), $path);

		// The MIME configuration file contains an array of file extensions and
		// their associated MIME types. We will spin through each extension the
		// developer wants to check to determine if the file's MIME type is in
		// the list of MIMEs we have for that extension.
		foreach ((array) $extensions as $extension)
		{
			if (isset($mimes[$extension]) and in_array($mime, (array) $mimes[$extension]))
			{
				return true;
			}
		}

		return false;
	}

	/**
	 * Recursively copy directory contents to another directory.
	 *
	 * @param  string  $source
	 * @param  string  $destination
	 * @return void
	 */
	public static function cpdir($source, $destination)
	{
		if ( ! is_dir($source)) return;

		// First we need to create the destination directory if it doesn't
		// already exists. This directory hosts all of the assets we copy
		// from the installed bundle's source directory.
		if ( ! is_dir($destination))
		{
			mkdir($destination);
		}

		$items = new FilesystemIterator($source, FilesystemIterator::SKIP_DOTS);

		foreach ($items as $item)
		{
			$location = $destination.DS.$item->getBasename();

			// If the file system item is a directory, we will recurse the
			// function, passing in the item directory. To get the proper
			// destination path, we'll add the basename of the source to
			// to the destination directory.
			if ($item->isDir())
			{
				$path = $item->getRealPath();

				static::cpdir($path, $location);
			}
			// If the file system item is an actual file, we can copy the
			// file from the bundle asset directory to the public asset
			// directory. The "copy" method will overwrite any existing
			// files with the same name.
			else
			{
				copy($item->getRealPath(), $location);
			}
		}
	}

}