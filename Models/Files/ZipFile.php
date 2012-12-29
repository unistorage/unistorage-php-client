<?php namespace Unistorage\Models\Files;

/**
 * @property-read string $uri
 */
class ZipFile extends File
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

	public function getUri()
	{
		return $this->uri;
	}
}
