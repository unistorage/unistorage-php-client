<?php namespace Unistorage;

/**
 * Common file
 *
 * @property-read string $mimeType
 * @property-read string $name
 * @property-read int $size
 * @property-read string $uri
 * @property-read string $type
 */
class RegularFile extends File
{
	const FILE_TYPE_AUDIO = 'audio';
	const FILE_TYPE_IMAGE = 'image';
	const FILE_TYPE_VIDEO = 'video';
	const FILE_TYPE_DOC = 'doc';

	const ACTION_RESIZE = 'resize';
	const ACTION_CONVERT = 'convert';
	const ACTION_GRAYSCALE = 'grayscale';
	const ACTION_ROTATE = 'rotate';
	const ACTION_WATERMARK = 'watermark';
	const ACTION_EXTRACT_AUDIO = 'extract_audio';

	/**
	 * @var string
	 */
	protected $mimeType;

	/**
	 * @var string
	 */
	protected $name;

	/**
	 * @var int
	 */
	protected $size;

	/**
	 * @var string
	 */
	protected $uri;

	/**
	 * @var string
	 */
	protected $type;

	/**
	 * @param array $properties
	 * @param string $resourceUri
	 * @param int $ttl
	 */
	function __construct($properties, $resourceUri, $ttl)
	{
		parent::__construct($resourceUri, $ttl);

		foreach ($properties as $field => $value) {
			$this->$field = $value;
		}
	}

	/**
	 * @param Template $template
	 * @return File
	 */
	public function apply($template)
	{
		return Unistorage::getInstance()->applyTemplate($this, $template);
	}

	public function getMimeType()
	{
		return $this->mimeType;
	}

	public function getName()
	{
		return $this->name;
	}

	public function getSize()
	{
		return $this->size;
	}

	public function getType()
	{
		return $this->type;
	}

	public function getUri()
	{
		return $this->uri;
	}
}
