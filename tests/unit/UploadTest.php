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
            $params = require(__DIR__ . '/../params.php');
            $this->unistorage = new Unistorage();
            $this->unistorage->host = $params['host'];
            $this->unistorage->token = $params['token'];
        }
    }

    public function testImage()
    {
        /** @var $imageFile ImageFile */
        $imageFile = $this->unistorage->uploadFile(FIXTURES_DIR . '/ImageFile.jpg');
        $this->assertInstanceOf('Unistorage\Models\Files\ImageFile', $imageFile);

        $resultFile = $imageFile->convert('png', $this->unistorage);
        $this->assertTrue(
            $resultFile instanceof ImageFile ||
            $resultFile instanceof TemporaryFile ||
            $resultFile instanceof PendingFile,
            'Failed asserting type of resultFile after convert'
        );
        $resultFile = $imageFile->grayscale($this->unistorage);
        $this->assertTrue(
            $resultFile instanceof ImageFile ||
            $resultFile instanceof TemporaryFile ||
            $resultFile instanceof PendingFile,
            'Failed asserting type of resultFile after grayscale'
        );
        $resultFile = $imageFile->resize(ImageFile::MODE_CROP_RESIZE, 50, 50, $this->unistorage);
        $this->assertTrue(
            $resultFile instanceof ImageFile ||
            $resultFile instanceof TemporaryFile ||
            $resultFile instanceof PendingFile,
            'Failed asserting type of resultFile after resize'
        );
        $resultFile = $imageFile->rotate(90, $this->unistorage);
        $this->assertTrue(
            $resultFile instanceof ImageFile ||
            $resultFile instanceof TemporaryFile ||
            $resultFile instanceof PendingFile,
            'Failed asserting type of resultFile after rotate'
        );
        $resultFile = $imageFile->watermark(
            $imageFile,
            20,
            20,
            20,
            20,
            ImageFile::CORNER_RIGHT_BOTTOM,
            $this->unistorage
        );
        $this->assertTrue(
            $resultFile instanceof ImageFile ||
            $resultFile instanceof TemporaryFile ||
            $resultFile instanceof PendingFile,
            'Failed asserting type of resultFile after watermark'
        );
        $this->setExpectedException('\Unistorage\USException');
        $imageFile->watermark($imageFile, 1000, 1000, 10, 10, ImageFile::CORNER_RIGHT_BOTTOM, $this->unistorage);
    }

    public function testTemplate()
    {
        $template = $this->unistorage->createTemplate(
            array(
                RegularFile::ACTION_RESIZE => array(
                    'mode' => ImageFile::MODE_KEEP_RATIO,
                    'w'    => 50,
                    'h'    => 50,
                ),
                RegularFile::ACTION_GRAYSCALE => array(),
            ),
            RegularFile::FILE_TYPE_IMAGE
        );
        $this->assertInstanceOf('Unistorage\Models\Template', $template);

        /** @var $imageFile ImageFile */
        $imageFile = $this->unistorage->uploadFile(FIXTURES_DIR . '/ImageFile.jpg');
        $this->assertInstanceOf('Unistorage\Models\Files\ImageFile', $imageFile);

        $resultFile = $imageFile->apply($template, $this->unistorage);
        $this->assertTrue(
            $resultFile instanceof ImageFile ||
            $resultFile instanceof TemporaryFile ||
            $resultFile instanceof PendingFile,
            'Failed asserting type of resultFile after apply template'
        );
    }

    public function testCreateZip()
    {
        $imageFile = $this->unistorage->uploadFile(FIXTURES_DIR . '/ImageFile.jpg');
        $this->assertInstanceOf('Unistorage\Models\Files\ImageFile', $imageFile);
        $zipFile = $this->unistorage->getZipped(array($imageFile), 'zipName.zip');
        $this->assertInstanceOf('Unistorage\Models\Files\ZipFile', $zipFile);
    }

    public function testAudio()
    {
        /** @var $audioFile AudioFile */
        $audioFile = $this->unistorage->uploadFile(FIXTURES_DIR . '/AudioFile.m4r');
        $this->assertInstanceOf('Unistorage\Models\Files\AudioFile', $audioFile);

        $this->assertNotEmpty($audioFile->bitrate);
        $this->assertNotEmpty($audioFile->duration);
        $this->assertEquals($audioFile->channels, 2);
        $this->assertEquals($audioFile->sampleRate, 44100);
        $this->assertEquals($audioFile->format, 'mov');
        $this->assertEquals($audioFile->codec, 'aac');
        $this->assertNotEmpty($audioFile->url);
        $this->assertEquals($audioFile->name, 'AudioFile.m4r');
        $this->assertEquals($audioFile->size, 966234);
        $this->assertEquals($audioFile->mimeType, 'audio/mp4');
        $this->assertEquals($audioFile->unistorageType, 'audio');
    }

    public function testVideo()
    {
        /** @var $videoFile VideoFile */
        $videoFile = $this->unistorage->uploadFile(FIXTURES_DIR . '/VideoFile.mov');
        $this->assertInstanceOf('Unistorage\Models\Files\VideoFile', $videoFile);

        $resultFile = $videoFile->extractAudio('mp3', $this->unistorage);
        $this->assertTrue(
            $resultFile instanceof AudioFile ||
            $resultFile instanceof TemporaryFile ||
            $resultFile instanceof PendingFile,
            'Failed asserting type of resultFile after extractAudio'
        );

        $this->assertEquals($videoFile->size, 1516948);
        $this->assertEquals($videoFile->name, 'VideoFile.mov');
        $this->assertEquals($videoFile->mimeType, 'video/quicktime');
        $this->assertEquals($videoFile->format, 'mov');
        $this->assertEquals($videoFile->unistorageType, 'video');
        $this->assertNotEmpty($videoFile->url);
        $this->assertEquals($videoFile->videoWidth, 1280);
        $this->assertNotEmpty($videoFile->audioBitrate);
        $this->assertEquals($videoFile->audioCodec, 'aac');
        $this->assertNotEmpty($videoFile->audioDuration);
        $this->assertNotEmpty($videoFile->audioSampleRate);
        $this->assertEquals($videoFile->audioChannels, 1);
        $this->assertNotEmpty($videoFile->videoBitrate);
        $this->assertEquals($videoFile->videoCodec, 'h264');
        $this->assertNotEmpty($videoFile->videoDuration);
        $this->assertEquals($videoFile->videoFps, 24);
        $this->assertEquals($videoFile->videoHeight, 720);
        $this->assertEquals($videoFile->videoWidth, 1280);

        $resultFile = $videoFile->captureFrame('jpeg', 0, $this->unistorage);
        $this->assertTrue(
            $resultFile instanceof ImageFile ||
            $resultFile instanceof TemporaryFile ||
            $resultFile instanceof PendingFile,
            'Failed asserting type of resultFile after captureFrame'
        );
    }
}
