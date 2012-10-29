<?php namespace Unistorage;

/**
 * File is not ready, but you can use alternate uri
 *
 * @property-read string uri
 */
class TemporaryFile extends File
{
	/**
	 * @var string
	 */
	protected $uri;

	/**
	 * @param string $uri
	 * @param string $resourceUri
	 * @param int $ttl
	 */
	function __construct($uri, $resourceUri, $ttl)
	{
		parent::__construct($resourceUri, $ttl);

		$this->uri = $uri;
	}

	public function getUri()
	{
		return $this->uri;
	}
}
