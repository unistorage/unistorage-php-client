<?php

use Unistorage\Unistorage;
use Unistorage\Models\Files\RegularFile;
use Unistorage\Models\Files\ImageFile;
use Unistorage\Models\Files\VideoFile;
use Unistorage\Models\Files\AudioFile;
use Unistorage\Models\Files\PendingFile;
use Unistorage\Models\Files\TemporaryFile;

class UploadTest extends PHPUnit_Framework_TestCase
{
	/** @var Unistorage */
	private $unistorage;

	protected function setUp()
	{
		if (is_null($this->unistorage)) {
			$params = require(__DIR__.'/../params.php');
			$this->unistorage = new Unistorage();
			$this->unistorage->host = $params['host'];
			$this->unistorage->token = $params['token'];
		}
	}

	public function testImage()
	{
		/** @var $imageFile ImageFile */
		$imageFile = $this->unistorage->uploadFile(FIXTURES_DIR.'/ImageFile.jpg');
		$this->assertInstanceOf('Unistorage\Models\Files\ImageFile', $imageFile);

		$resultFile = $imageFile->convert('png', $this->unistorage);
		$this->assertTrue(
			$resultFile instanceof ImageFile ||
			$resultFile instanceof TemporaryFile ||
			$resultFile instanceof PendingFile,
			'Failed asserting type of resultFile after convert');
		$resultFile = $imageFile->grayscale($this->unistorage);
		$this->assertTrue(
			$resultFile instanceof ImageFile ||
			$resultFile instanceof TemporaryFile ||
			$resultFile instanceof PendingFile,
			'Failed asserting type of resultFile after grayscale');
		$resultFile = $imageFile->resize(ImageFile::MODE_CROP, 50, 50, $this->unistorage);
		$this->assertTrue(
			$resultFile instanceof ImageFile ||
			$resultFile instanceof TemporaryFile ||
			$resultFile instanceof PendingFile,
			'Failed asserting type of resultFile after resize');
		$resultFile = $imageFile->rotate(90, $this->unistorage);
		$this->assertTrue(
			$resultFile instanceof ImageFile ||
			$resultFile instanceof TemporaryFile ||
			$resultFile instanceof PendingFile,
			'Failed asserting type of resultFile after rotate');
		$resultFile = $imageFile->watermark($imageFile, 20, 20, 20, 20, ImageFile::CORNER_RIGHT_BOTTOM, $this->unistorage);
		$this->assertTrue(
			$resultFile instanceof ImageFile ||
			$resultFile instanceof TemporaryFile ||
			$resultFile instanceof PendingFile,
			'Failed asserting type of resultFile after watermark');
	}

	public function testTemplate()
	{
		$template = $this->unistorage->createTemplate(array(
			RegularFile::ACTION_RESIZE => array(
				'mode' => ImageFile::MODE_KEEP,
				'w' => 50,
				'h' => 50,
			),
			RegularFile::ACTION_GRAYSCALE => array(),
		), RegularFile::FILE_TYPE_IMAGE);
		$this->assertInstanceOf('Unistorage\Models\Template', $template);

		/** @var $imageFile ImageFile */
		$imageFile = $this->unistorage->uploadFile(FIXTURES_DIR.'/ImageFile.jpg');
		$this->assertInstanceOf('Unistorage\Models\Files\ImageFile', $imageFile);

		$resultFile = $imageFile->apply($template, $this->unistorage);
		$this->assertTrue(
			$resultFile instanceof ImageFile ||
				$resultFile instanceof TemporaryFile ||
				$resultFile instanceof PendingFile,
			'Failed asserting type of resultFile after apply template');
	}

	public function testCreateZip()
	{
		$imageFile = $this->unistorage->uploadFile(FIXTURES_DIR.'/ImageFile.jpg');
		$this->assertInstanceOf('Unistorage\Models\Files\ImageFile', $imageFile);
		$zipFile = $this->unistorage->getZipped(array($imageFile), 'zipName.zip');
		$this->assertInstanceOf('Unistorage\Models\Files\ZipFile', $zipFile);
	}

	public function testAudio()
	{
		/** @var $audioFile AudioFile */
		$audioFile = $this->unistorage->uploadFile(FIXTURES_DIR.'/AudioFile.m4r');
		$this->assertInstanceOf('Unistorage\Models\Files\AudioFile', $audioFile);
	}

	public function testVideo()
	{
		/** @var $videoFile VideoFile */
		$videoFile = $this->unistorage->uploadFile(FIXTURES_DIR.'/VideoFile.mov');
		$this->assertInstanceOf('Unistorage\Models\Files\VideoFile', $videoFile);

		$resultFile = $videoFile->extractAudio('mp3', $this->unistorage);
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

		$resultFile = $videoFile->captureFrame('jpeg', 0, $this->unistorage);
		$this->assertTrue(
			$resultFile instanceof ImageFile ||
				$resultFile instanceof TemporaryFile ||
				$resultFile instanceof PendingFile,
			'Failed asserting type of resultFile after captureFrame');
	}
}