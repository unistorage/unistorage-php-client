<?php namespace Unistorage\Models\Files;

/**
 * File is not ready
 *
 * @property-read int    $ttl
 */
class NonPermanentFile extends File
{
    /**
     * @var int
     */
    protected $ttl;

    /**
     * @return int
     */
    public function getTtl()
    {
        return $this->ttl;
    }
}