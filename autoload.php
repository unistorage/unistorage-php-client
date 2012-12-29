<?php

$success = spl_autoload_register(function ($className)
{
	if ($className == 'CurlHelper') {
		require(__DIR__.'/helpers/CurlHelper/CurlHelper.php');
		return true;
	}

	if (strpos($className, 'Unistorage\\') !== false) {
		$classFile = substr($className, strlen('Unistorage\\'));
		$classFile = str_replace('\\', '/', $classFile);

		require_once(__DIR__.'/'.$classFile.'.php');
		return true;
	} else {
		return false;
	}
});

if (!$success)
	throw new \Exception('can\'t register autoload function');