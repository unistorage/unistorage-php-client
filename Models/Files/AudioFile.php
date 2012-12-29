<?php namespace Unistorage\Models\Files;

use Unistorage\Unistorage;

/**
 * @property-read string $codec
 * @property-read int $length
 */
class AudioFile extends RegularFile
{
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

	public function getLength()
	{
		return $this->length;
	}

	/**
	 * @param string $format
	 * @param Unistorage $unistorage
	 * @return File
	 */
	public function convert($format, $unistorage)
	{
		return $unistorage->applyAction($this, RegularFile::ACTION_CONVERT, array(
			'to' => $format,
		));
	}
}
