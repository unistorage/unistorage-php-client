<?php namespace Unistorage\Models\Files;

use Unistorage\Unistorage;

/**
 * @property-read string $codec
 * @property-read string $format
 * @property-read string $channels
 * @property-read string $sampleRate
 * @property-read string $duration
 * @property-read string $bitrate
 */
class AudioFile extends RegularFile
{
    /**
     * @var string
     */
    protected $codec;

    /**
     * @var string
     */
    protected $format;

    /**
     * @var int
     */
    protected $channels;

    /**
     * @var int in Hz
     */
    protected $sampleRate;

    /**
     * @var float in seconds
     */
    protected $duration;

    /**
     * @var int in bytes
     */
    protected $bitrate;

    /**
     * @return string
     */
    public function getCodec()
    {
        return $this->codec;
    }

    /**
     * @return int
     */
    public function getDuration()
    {
        return $this->duration;
    }

    /**
     * @return string
     */
    public function getBitrate()
    {
        return $this->bitrate;
    }

    /**
     * @return int
     */
    public function getChannels()
    {
        return $this->channels;
    }

    /**
     * @return string
     */
    public function getFormat()
    {
        return $this->format;
    }

    /**
     * @return string
     */
    public function getSampleRate()
    {
        return $this->sampleRate;
    }

    /**
     * @param string $format
     * @param Unistorage $unistorage
     * @return File
     */
    public function convert($format, $unistorage)
    {
        return $unistorage->applyAction(
            $this,
            RegularFile::ACTION_CONVERT,
            array(
                'to' => $format,
            )
        );
    }
}
