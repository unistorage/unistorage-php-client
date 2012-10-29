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

	}

	/**
	 * @param string $format
	 * @return File
	 */
	public function convert($format)
	{

	}

	/**
	 * @return File
	 */
	public function grayscale()
	{

	}

	/**
	 * @param int $angle CCW
	 * @return File
	 */
	public function rotate($angle)
	{

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

	}
}
