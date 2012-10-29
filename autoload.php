<?php

spl_autoload_register(function ($className) {
	$includeDirs = array(
		'/models/',
		'/models/files',
		'/helpers/CurlHelper/',
	);

	foreach ($includeDirs as $dir)
		if (file_exists(UNISTORAGE_CLIENT.$dir.$className.'.php'))
			require_once(UNISTORAGE_CLIENT.$dir.$className.'.php');
});
