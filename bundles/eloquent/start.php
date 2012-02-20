<?php

Laravel\Autoloader::map(array(
	'Eloquent\\Model'    => __DIR__.DS.'model'.EXT,
	'Eloquent\\Hydrator' => __DIR__.DS.'hydrator'.EXT,
));