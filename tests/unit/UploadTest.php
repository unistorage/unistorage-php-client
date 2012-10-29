<?php

use Unistorage\Unistorage;
use Unistorage\RegularFile;
use Unistorage\ImageFile;

class UploadTest extends PHPUnit_Framework_TestCase
{
	/**
	 * @var Unistorage
	 */
	private $us;

	protected function setUp()
	{
		$params = require(__DIR__.'/../params.php');
		$this->us = new Unistorage($params['host'], $params['token']);
	}

	public function testUploadImage()
	{
		$imageFile = $this->us->uploadFile(FIXTURES_DIR.'/ImageFile.jpg');
		$this->assertInstanceOf('\Unistorage\ImageFile', $imageFile);
	}

	public function testCreateTemplate()
	{
		$template = $this->us->createTemplate(array(
			RegularFile::ACTION_RESIZE => array(
				'mode' => ImageFile::MODE_KEEP,
				'w' => 50,
				'h' => 50,
			),
			RegularFile::ACTION_GRAYSCALE => array(),
		), RegularFile::FILE_TYPE_IMAGE);

		$this->assertInstanceOf('\Unistorage\Template', $template);
	}

	public function testCreateZip()
	{
		$imageFile = $this->us->uploadFile(FIXTURES_DIR.'/ImageFile.jpg');
		$this->assertInstanceOf('\Unistorage\ImageFile', $imageFile);
		$zipFile = $this->us->getZipped(array($imageFile), 'zipName.zip');
		$this->assertInstanceOf('\Unistorage\ZipFile', $zipFile);
	}
}