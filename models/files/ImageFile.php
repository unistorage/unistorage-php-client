<?php namespace Unistorage;

/**
 * @property-read int $width
 * @property-read int $height
 */
class ImageFile extends RegularFile
{
	/**
	 * @var int
	 */
	protected $width;

	/**
	 * @var int
	 */
	protected $height;

	const MODE_KEEP = 'keep';
	const MODE_CROP = 'crop';
	const MODE_RESIZE = 'resize';

	const CORNER_LEFT_TOP = 'nw';
	const CORNER_LEFT_BOTTOM = 'sw';
	const CORNER_RIGHT_TOP = 'ne';
	const CORNER_RIGHT_BOTTOM = 'se';

	public function getHeight()
	{
		return $this->height;
	}

	public function getWidth()
	{
		return $this->width;
	}

	/**
	 * @param Unistorage $unistorage
	 * @param string $mode
	 * @param int $width
	 * @param int $height
	 * @return File
	 */
	public function resize($unistorage, $mode, $width, $height)
	{
		$actionParams = array(
			'mode' => $mode,
		);
		if (!empty($width))
			$actionParams['w'] = $width;
		if (!empty($height))
			$actionParams['h'] = $height;

		return $unistorage->applyAction($this, RegularFile::ACTION_RESIZE, $actionParams);
	}

	/**
	 * @param Unistorage $unistorage
	 * @param string $format
	 * @return File
	 */
	public function convert($unistorage, $format)
	{
		return $unistorage->applyAction($this, RegularFile::ACTION_CONVERT, array(
			'to' => $format,
		));
	}

	/**
	 * @param Unistorage $unistorage
	 * @return File
	 */
	public function grayscale($unistorage)
	{
		return $unistorage->applyAction($this, RegularFile::ACTION_GRAYSCALE);
	}

	/**
	 * @param Unistorage $unistorage
	 * @param int $angle 90, 180, 270. CCW
	 * @return File
	 */
	public function rotate($unistorage, $angle)
	{
		return $unistorage->applyAction($this, RegularFile::ACTION_ROTATE, array(
			'angle' => $angle,
		));
	}

	/**
	 * $wmWidth, $wmHeight, $horizontalPadding, $verticalPadding my have following format:
	 * <ul>
	 * <li> (\d+)px - number calculates in pixels
	 * <li> (\d+) - number calculates in percents
	 * </ul>
	 * @param Unistorage $unistorage
	 * @param ImageFile $watermark
	 * @param string $wmWidth watermark width
	 * @param string $wmHeight watermark height
	 * @param string $horizontalPadding padding of watermark
	 * @param string $verticalPadding padding of watermark
	 * @param string $corner one of ImageFile::CORNER_*
	 * @return File
	 */
	public function watermark($unistorage, $watermark, $wmWidth, $wmHeight, $horizontalPadding, $verticalPadding, $corner)
	{
		return $unistorage->applyAction($this, RegularFile::ACTION_WATERMARK, array(
			'watermark' => $watermark->resourceUri,
			'w' => $wmWidth,
			'h' => $wmHeight,
			'w_pad' => $horizontalPadding,
			'h_pad' => $verticalPadding,
			'corner' => $corner,
		));
	}
}
