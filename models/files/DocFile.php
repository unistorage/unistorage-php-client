<?php namespace Unistorage;

class DocFile extends RegularFile
{
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
