<?php

$success = spl_autoload_register(
    function ($className) {
        if ($className == 'CurlHelper') {
            require(__DIR__ . '/helpers/CurlHelper/CurlHelper.php');
            return true;
        }

        if (strpos($className, 'Unistorage\\') === 0) {
            $classFile = substr($className, strlen('Unistorage\\'));
            $classFile = str_replace('\\', '/', $classFile);

            /** @noinspection PhpIncludeInspection */
            require_once(__DIR__ . '/' . $classFile . '.php');
            return true;
        } else {
            return false;
        }
    }
);

if (!$success) {
    throw new \Exception('can\'t register autoload function');
}