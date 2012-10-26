<?php

class UploadTest extends PHPUnit_Framework_TestCase
{
//	private $acceptableStatuses = array('ok' => true, 'wait' => true, 'error' => false);

//	public function testUploadImage()
//	{
//		$uc = UnistorageClient::app();
//		$success = $uc->uploadFile(__DIR__ . '/../fixtures/ImageFile.jpg', 'dev_test');
//		$this->assertTrue($success, 'Push image to server');
//		$result = $uc->getResult();
//		$this->assertEquals('ok', $result->status, 'Status is ok');
//
//		sleep(1);
//		/** @var $file ImageFile */
//		$file = $uc->getFile($result->id);
//		$this->assertEquals('ImageFile',get_class($file), 'Get image file');
//
//		/** @var $resizedFile BaseFile */
//		$resizedFile = $file->resize(ImageFile::RESIZE_MODE_RESIZE,200,210);
//		sleep(1);
//
//		$finalyResizedFile = $uc->getFile($resizedFile->getUid());
//
//		$this->assertEquals('ImageFile',get_class($finalyResizedFile), 'Get image file');
//		$this->assertEquals(200,$finalyResizedFile->getWidth(), 'Get image file');
//		$this->assertEquals(210,$finalyResizedFile->getHeight(), 'Get image file');
//	}

}