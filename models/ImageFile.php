<?php

class ImageFile extends BaseFile
{
	private $width;
	private $height;

	protected $watermarkSupported = true;

	const RESIZE_MODE_KEEP = 'keep';
	const RESIZE_MODE_CROP = 'crop';
	const RESIZE_MODE_RESIZE = 'resize';

	private $resizeConsts = array(
		self::RESIZE_MODE_KEEP,
		self::RESIZE_MODE_CROP,
		self::RESIZE_MODE_RESIZE,
	);

	public function __construct($uid, $info, $ttl)
	{
		parent::__construct($uid, $info, $ttl);
		if ($info) {
			$this->width = $info->fileinfo->width;
			$this->height = $info->fileinfo->height;
		}
	}

	public function getHeight()
	{
		return $this->height;
	}

	public function getWidth()
	{
		return $this->width;
	}

	public function resize($mode = self::RESIZE_MODE_KEEP, $width = null, $height = null)
	{
		if (!(int)$width && !(int)$height)
			throw new Exception ('Incorrect height or width');

		if(!in_array($mode,$this->resizeConsts))
			throw new Exception ('Incorrect resize mode');

		$params = array(
			'mode' => $mode,
		);
		if($width) $params['w'] = $width;
		if($height) $params['h'] = $height;

		$uc = UnistorageClient::app();
		return $uc->action($this->getUid(),'resize',$params);
	}
}
