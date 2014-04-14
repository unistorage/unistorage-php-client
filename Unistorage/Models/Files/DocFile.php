<?php namespace Unistorage\Models\Files;

use Unistorage\Unistorage;

class DocFile extends RegularFile
{
    /**
     * @param  string $format
     * @param bool $lowPriority
     * @param  Unistorage $unistorage
     *
     * @return File
     */
    public function convert($format, $lowPriority = false, $unistorage)
    {
        return $unistorage->applyAction(
            $this,
            RegularFile::ACTION_CONVERT,
            array(
                'to' => $format,
            ),
            $lowPriority
        );
    }
}
