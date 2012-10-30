<?php namespace Unistorage;

/**
 * @property-read int $width
 * @property-read int $height
 */
class ImageFile extends RegularFile
{
	/**
	 * @var string
	 */
	protected $type = RegularFile::FILE_TYPE_IMAGE;

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
	 * @param string $mode
	 * @param int $width
	 * @param int $height
	 * @return File
	 */
	public function resize($mode, $width, $height)
	{
		return Unistorage::getInstance()->applyAction($this, RegularFile::ACTION_RESIZE, array(
			'mode' => $mode,
			'w' => $width,
			'h' => $height,
		));
	}

	/**
	 * @param string $format
	 * @return File
	 */
	public function convert($format)
	{
		return Unistorage::getInstance()->applyAction($this, RegularFile::ACTION_CONVERT, array(
			'to' => $format,
		));
	}

	/**
	 * @return File
	 */
	public function grayscale()
	{
		return Unistorage::getInstance()->applyAction($this, RegularFile::ACTION_GRAYSCALE);
	}

	/**
	 * @param int $angle 90, 180, 270. CCW
	 * @return File
	 */
	public function rotate($angle)
	{
		return Unistorage::getInstance()->applyAction($this, RegularFile::ACTION_ROTATE, array(
			'angle' => $angle,
		));
	}

	/**
	 * $wmWidth, $wmHeight, $horizontalPadding, $verticalPadding my have following format:
	 * <ul>
	 * <li> (\d+)px - number calculates in pixels
	 * <li> (\d+) - number calculates in percents
	 * </ul>
	 * @param ImageFile $watermark
	 * @param string $wmWidth watermark width
	 * @param string $wmHeight watermark height
	 * @param string $horizontalPadding padding of watermark
	 * @param string $verticalPadding padding of watermark
	 * @param string $corner one of ImageFile::CORNER_*
	 * @return File
	 */
	public function watermark($watermark, $wmWidth, $wmHeight, $horizontalPadding, $verticalPadding, $corner)
	{
		return Unistorage::getInstance()->applyAction($this, RegularFile::ACTION_WATERMARK, array(
			'watermark' => $watermark->resourceUri,
			'w' => $wmWidth,
			'h' => $wmHeight,
			'w_pad' => $horizontalPadding,
			'h_pad' => $verticalPadding,
			'corner' => $corner,
		));
	}
}
