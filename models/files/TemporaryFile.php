<?php namespace Unistorage;

/**
 * File is not ready, but you can use alternate uri
 *
 * @property-read string url
 */
class TemporaryFile extends File
{
	/**
	 * @var string
	 */
	protected $url;

	/**
	 * @param string $url
	 * @param string $resourceUri
	 * @param int $ttl
	 */
	function __construct($url, $resourceUri, $ttl)
	{
		parent::__construct($resourceUri, $ttl);

		$this->url = $url;
	}

	public function getUrl()
	{
		return $this->url;
	}
}
