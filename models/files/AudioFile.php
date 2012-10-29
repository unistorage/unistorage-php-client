<?php namespace Unistorage;

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
}
