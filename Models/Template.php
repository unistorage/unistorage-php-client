<?php namespace Unistorage\Models;

/**
 * @property-read string $resourceUri
 */
class Template extends Component
{
	/**
	 * @var string
	 */
	private $resourceUri;

	/**
	 * @param string $resourceUri
	 */
	function __construct($resourceUri)
	{
		$this->resourceUri = $resourceUri;
	}

	public function getResourceUri()
	{
		return $this->resourceUri;
	}
}
