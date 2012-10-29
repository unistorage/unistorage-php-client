<?php namespace Unistorage;

/**
 * @property-read int $ttl
 * @property-read string $resourceUri
 */
abstract class File extends Component
{
	/**
	 * @var int
	 */
	private $ttl;

	/**
	 * @var string
	 */
	private $resourceUri;

	/**
	 * @param string $resourceUri
	 * @param int $ttl
	 */
	function __construct($resourceUri, $ttl)
	{
		$this->resourceUri = $resourceUri;
		$this->ttl = $ttl;
	}

	public function getResourceUri()
	{
		return $this->resourceUri;
	}

	public function getTtl()
	{
		return $this->ttl;
	}
}
