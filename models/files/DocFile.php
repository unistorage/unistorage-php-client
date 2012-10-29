<?php namespace Unistorage;

class DocFile extends RegularFile
{
	/**
	 * @var string
	 */
	protected $type = RegularFile::FILE_TYPE_DOC;

	/**
	 * @param string $format
	 * @return File
	 */
	public function convert($format)
	{

	}
}
