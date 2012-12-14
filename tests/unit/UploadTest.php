<?php

use Unistorage\Unistorage;
use Unistorage\RegularFile;
use Unistorage\ImageFile;
use Unistorage\VideoFile;
use Unistorage\AudioFile;
use Unistorage\PendingFile;
use Unistorage\TemporaryFile;

class UploadTest extends PHPUnit_Framework_TestCase
{

	protected function setUp()
	{
		if (is_null(Unistorage::getInstance())) {
			$params = require(__DIR__.'/../params.php');
			Unistorage::createInstance($params['host'], $params['token']);
		}
	}

	public function testImage()
	{
		/** @var $imageFile ImageFile */
		$imageFile = Unistorage::getInstance()->uploadFile(FIXTURES_DIR.'/ImageFile.jpg');
		$this->assertInstanceOf('\Unistorage\ImageFile', $imageFile);

		$resultFile = $imageFile->convert('png');
		$this->assertTrue(
			$resultFile instanceof ImageFile ||
			$resultFile instanceof TemporaryFile ||
			$resultFile instanceof PendingFile,
			'Failed asserting type of resultFile after convert');
		$resultFile = $imageFile->grayscale();
		$this->assertTrue(
			$resultFile instanceof ImageFile ||
			$resultFile instanceof TemporaryFile ||
			$resultFile instanceof PendingFile,
			'Failed asserting type of resultFile after grayscale');
		$resultFile = $imageFile->resize(\Unistorage\ImageFile::MODE_CROP, 50, 50);
		$this->assertTrue(
			$resultFile instanceof ImageFile ||
			$resultFile instanceof TemporaryFile ||
			$resultFile instanceof PendingFile,
			'Failed asserting type of resultFile after resize');
		$resultFile = $imageFile->rotate(90);
		$this->assertTrue(
			$resultFile instanceof ImageFile ||
			$resultFile instanceof TemporaryFile ||
			$resultFile instanceof PendingFile,
			'Failed asserting type of resultFile after rotate');
		$resultFile = $imageFile->watermark($imageFile, 20, 20, 20, 20, \Unistorage\ImageFile::CORNER_RIGHT_BOTTOM);
		$this->assertTrue(
			$resultFile instanceof ImageFile ||
			$resultFile instanceof TemporaryFile ||
			$resultFile instanceof PendingFile,
			'Failed asserting type of resultFile after watermark');
	}

	public function testTemplate()
	{
		$template = Unistorage::getInstance()->createTemplate(array(
			RegularFile::ACTION_RESIZE => array(
				'mode' => ImageFile::MODE_KEEP,
				'w' => 50,
				'h' => 50,
			),
			RegularFile::ACTION_GRAYSCALE => array(),
		), RegularFile::FILE_TYPE_IMAGE);
		$this->assertInstanceOf('\Unistorage\Template', $template);

		/** @var $imageFile ImageFile */
		$imageFile = Unistorage::getInstance()->uploadFile(FIXTURES_DIR.'/ImageFile.jpg');
		$this->assertInstanceOf('\Unistorage\ImageFile', $imageFile);

		$resultFile = $imageFile->apply($template);
		$this->assertTrue(
			$resultFile instanceof ImageFile ||
				$resultFile instanceof TemporaryFile ||
				$resultFile instanceof PendingFile,
			'Failed asserting type of resultFile after apply template');
	}

	public function testCreateZip()
	{
		$imageFile = Unistorage::getInstance()->uploadFile(FIXTURES_DIR.'/ImageFile.jpg');
		$this->assertInstanceOf('\Unistorage\ImageFile', $imageFile);
		$zipFile = Unistorage::getInstance()->getZipped(array($imageFile), 'zipName.zip');
		$this->assertInstanceOf('\Unistorage\ZipFile', $zipFile);
	}

	public function testAudio()
	{
		/** @var $audioFile AudioFile */
		$audioFile = Unistorage::getInstance()->uploadFile(FIXTURES_DIR.'/AudioFile.m4r');
		$this->assertInstanceOf('\Unistorage\AudioFile', $audioFile);
	}

	public function testVideo()
	{
		/** @var $videoFile VideoFile */
		$videoFile = Unistorage::getInstance()->uploadFile(FIXTURES_DIR.'/VideoFile.mov');
		$this->assertInstanceOf('\Unistorage\VideoFile', $videoFile);

		$resultFile = $videoFile->extractAudio('mp3');
		$this->assertTrue(
			$resultFile instanceof AudioFile ||
				$resultFile instanceof TemporaryFile ||
				$resultFile instanceof PendingFile,
			'Failed asserting type of resultFile after extractAudio');

		$this->assertNotEmpty($videoFile->audioBitrate);
		$this->assertNotEmpty($videoFile->audioCodec);
		$this->assertNotEmpty($videoFile->audioDuration);
		$this->assertNotEmpty($videoFile->audioSampleRate);
		$this->assertNotEmpty($videoFile->videoBitrate);
		$this->assertNotEmpty($videoFile->videoCodec);
		$this->assertNotEmpty($videoFile->videoDuration);
		$this->assertNotEmpty($videoFile->videoFps);
		$this->assertNotEmpty($videoFile->videoHeight);
		$this->assertNotEmpty($videoFile->videoWidth);
		$this->assertNotEmpty($videoFile->mimeType);
		$this->assertNotEmpty($videoFile->size);
		$this->assertNotEmpty($videoFile->url);
		$this->assertNotEmpty($videoFile->url);
	}
}