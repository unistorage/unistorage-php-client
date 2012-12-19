<?php namespace Unistorage;

class DocFile extends RegularFile
{
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
}
