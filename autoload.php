<?php namespace Unistorage;

$success = spl_autoload_register(function ($className) {
	static $includeDirs = array(
		'/models',
		'/models/files',
		'/helpers/CurlHelper',
	);

	if (strpos($className, 'Unistorage\\') === 0)
		$className = substr($className, strlen('Unistorage\\'));

	foreach ($includeDirs as $dir)
		if (file_exists(UNISTORAGE_CLIENT.$dir.'/'.$className.'.php'))
			require_once(UNISTORAGE_CLIENT.$dir.'/'.$className.'.php');
});

if (!$success)
	throw new \Exception('can\'t register autoload function');