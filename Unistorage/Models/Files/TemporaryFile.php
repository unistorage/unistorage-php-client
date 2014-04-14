<?php namespace Unistorage\Models\Files;

/**
 * File is not ready, but you can use alternate uri
 *
 * @property-read string url
 */
class TemporaryFile extends NonPermanentFile
{
    /**
     * @var string
     */
    protected $url;

    /**
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
    }
}
