<?php namespace Laravel\CLI\Tasks\Bundle\Providers;

use Laravel\Request;

class Github extends Provider {

	/**
	 * Install the given bundle into the application.
	 *
	 * @param  string  $bundle
	 * @return void
	 */
	public function install($bundle)
	{
		$method = (Request::server('cli.zip')) ? 'zipball' : 'submodule';

		$this->$method($bundle);
	}

	/**
	 * Install a Github hosted bundle from Zip.
	 *
	 * @param  string  $bundle
	 * @return void
	 */
	protected function zipball($bundle)
	{
		$url = "http://nodeload.github.com/{$bundle['location']}/zipball/master";

		parent::zipball($bundle, $url, true);

		echo "Bundle [{$bundle['name']}] has been installed!".PHP_EOL;
	}

	/**
	 * Install a Github hosted bundle using submodules.
	 *
	 * @param  string  $bundle
	 * @return void
	 */
	protected function submodule($bundle)
	{
		$repository = "git@github.com:{$bundle['location']}.git";

		$this->directory($bundle);

		// We need to just extract the basename of the bundle path when
		// adding the submodule. Of course, we can't add a submodule to
		// a location outside of the Git repository, so we don't need
		// the full bundle path.
		$root = basename(path('bundle')).'/';

		passthru('git submodule add '.$repository.' '.$root.$this->path($bundle));

		passthru('git submodule update');
	}

	/**
	 * Create the path to the bundle's dirname.
	 *
	 * @param  array  $bundle
	 * @return void
	 */
	protected function directory($bundle)
	{
		// If the installation target directory doesn't exist, we will create
		// it recursively so that we can properly install the bundle to the
		// correct path in the application.
		$target = dirname(path('bundle').$this->path($bundle));

		if ( ! is_dir($target))
		{
			mkdir($target, 0777, true);
		}
	}

}