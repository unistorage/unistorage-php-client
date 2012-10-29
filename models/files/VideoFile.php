<?php namespace Unistorage;

/**
 * @property-read int $width
 * @property-read int $height
 * @property-read string $codec
 * @property-read int $length
 */
class VideoFile extends RegularFile
{
	/**
	 * @var string
	 */
	protected $type = RegularFile::FILE_TYPE_VIDEO;

	/**
	 * @var int
	 */
	protected $width;

	/**
	 * @var int
	 */
	protected $height;

	/**
	 * @var string
	 */
	protected $codec;

	/**
	 * @var int in seconds
	 */
	protected $length;

	public function getCodec()
	{
		return $this->codec;
	}

	public function getHeight()
	{
		return $this->height;
	}

	public function getLength()
	{
		return $this->length;
	}

	public function getWidth()
	{
		return $this->width;
	}

	/**
	 * @param string $format
	 * @param string $vCodec
	 * @param string $aCodec
	 * @return File
	 */
	public function convert($format, $vCodec, $aCodec)
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
