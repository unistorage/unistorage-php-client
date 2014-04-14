<?php namespace Unistorage\Models\Files;

/**
 * @property-read string $uri
 */
class ZipFile extends NonPermanentFile
{
    /**
     * @var string
     */
    protected $url;

    public function getUri()
    {
        return $this->uri;
    }
}
