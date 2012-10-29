<?php

class UploadTest extends PHPUnit_Framework_TestCase
{
	/**
	 * @var \Unistorage\Unistorage
	 */
	private $us;

	protected function setUp()
	{
		$params = require_once(__DIR__.'/../params.php');
		$this->us = new \Unistorage\Unistorage($params['host'], $params['token']);
	}

	public function testUploadImage()
	{
		$imageFile = $this->us->uploadFile(FIXTURES_DIR.'/ImageFile.jpg');
		$this->assertInstanceOf('\Unistorage\ImageFile', $imageFile);
	}

}