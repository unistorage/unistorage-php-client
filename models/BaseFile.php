<?php

class BaseFile
{
	private $uid;
	private $created;
	private $ttl;
	private $uri;
	private $name;
	private $size;
	protected $watermarkSupported = false;

	const WATERMARK_CORNER_NE = 'ne';
	const WATERMARK_CORNER_SE = 'se';
	const WATERMARK_CORNER_SW = 'sw';
	const WATERMARK_CORNER_NW = 'nw';

	private $watermarkCorners = array(
		self::WATERMARK_CORNER_NE,
		self::WATERMARK_CORNER_SE,
		self::WATERMARK_CORNER_SW,
		self::WATERMARK_CORNER_NW,
	);

	public function __construct($uid, $info, $ttl)
	{
		$this->created = time();
		$this->ttl = $ttl;
		$this->uid = $uid;

		if ($info) {
			$this->uri = $info->uri;
			$this->size = $info->size;
			$this->name = $info->name;
		}
	}

	/**
	 * @return int Time left to live
	 */
	public function getExpire()
	{
		$expire = time() - $this->created - $this->ttl;

		return $expire < 0 ? 0 : $expire;
	}

	public function getUid()
	{
		return $this->uid;
	}

	public function getName()
	{
		return $this->name;
	}

	public function getSize()
	{
		return $this->size;
	}

	public function getUri()
	{
		return $this->uri;
	}

	public function watermark($watermark_id, $width, $height, $h_pad, $w_pad, $corner = self::WATERMARK_CORNER_SW)
	{
		if (!$this->watermarkSupported)
			throw new Exception('This file type doesn\'t support watermarking');

		if (!(int)$width || !(int)$height || !(int)$h_pad || !(int)$w_pad)
			throw new Exception ('Incorrect position params');

		if (!in_array($corner, $this->watermarkCorners))
			throw new Exception ('Incorrect corner name');

		if (!(int)$watermark_id)
			throw new Exception ('Incorrect watermark id');

		$params = array(
			'corner' => $corner,
			'width' => $width,
			'height' => $height,
			'h_pad' => $h_pad,
			'w_pad' => $w_pad,
			'watermark_id' => (int)$watermark_id,
		);

		$uc = UnistorageClient::app();

		return $uc->action($this->getUid(), 'watermark', $params);
	}
}
