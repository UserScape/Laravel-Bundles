## Laravel Bundles

Laravel bundles is an application that allows you to create a site to list bundles that can
be installed by the [Laravel](http://laravel.com) framework.

## Installation

Installation is fairly easy however it is not automated. To install this please follow these steps:

* Download the latest release
* Edit application/config/application.php
	* Change the key
* Created your database and modify application/config/database.php
* Via cli run the following commands:

```bash
php artisan migrate:install
php artisan migrate
```
* Visit [GitHub](https://github.com/settings/applications/new) and register your application. The urls you will need are:
	* URL: http://yoursite.com
	* Callback: http://yoursite.com/user/login/github
* Modify application/config/github.php with your GitHub keys
* Next load the site in your browser and login with GitHub. The first account creted is considered an admin.

## Support

If you need support please use the GitHub issue tracker. If you want to fix a bug or make an improvement consider
forking and submitting a pull request. The world is small, make your mark!

### Contributing to Laravel

Contributions are encouraged and welcome; however, please review the Developer Certificate of Origin in the "bundles.license.txt" file included in the repository. All commits must be signed off using the "-s" switch.

	git commit -s -m "thie commit will be signed off automatically!"

## License

The MIT License (MIT)

Copyright (c) 2012, UserScape, Inc

Permission is hereby granted, free of charge, to any person obtaining a copy of
this software and associated documentation files (the "Software"), to deal in
the Software without restriction, including without limitation the rights to
use, copy, modify, merge, publish, distribute, sublicense, and/or sell copies of
the Software, and to permit persons to whom the Software is furnished to do so,
subject to the following conditions:

The above copyright notice and this permission notice shall be included in all
copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY, FITNESS
FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR
COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER
IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN
CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.