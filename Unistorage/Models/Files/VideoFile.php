<?php namespace Unistorage\Models\Files;

use Unistorage\Unistorage;

/**
 * @property-read string $format
 * @property-read int    $videoWidth
 * @property-read int    $videoHeight
 * @property-read string $videoCodec
 * @property-read float  $videoDuration
 * @property-read int    $videoBitrate
 * @property-read int    $videoFps
 * @property-read int    $audioSampleRate
 * @property-read string $audioCodec
 * @property-read int    $audioBitrate
 * @property-read float  $audioDuration
 * @property-read int    $audioChannels
 */
class VideoFile extends RegularFile
{
    /**
     * @var int
     */
    protected $videoWidth;

    /**
     * @var int
     */
    protected $videoHeight;

    /**
     * @var string
     */
    protected $videoCodec;

    /**
     * @var float in seconds
     */
    protected $videoDuration;

    /**
     * @var int in bytes
     */
    protected $videoBitrate;

    /**
     * @var int
     */
    protected $videoFps;

    /**
     * @var int in Hz
     */
    protected $audioSampleRate;

    /**
     * @var string
     */
    protected $audioCodec;

    /**
     * @var int in bytes
     */
    protected $audioBitrate;

    /**
     * @var float in seconds
     */
    protected $audioDuration;

    /**
     * @var int
     */
    protected $audioChannels;

    /**
     * @var string
     */
    protected $format;

    /**
     * @param string $format
     * @param string $vCodec
     * @param string $aCodec
     * @param bool $lowPriority
     * @param Unistorage $unistorage
     *
     * @return File
     */
    public function convert($format, $vCodec, $aCodec, $lowPriority = false, $unistorage)
    {
        return $unistorage->applyAction(
            $this,
            RegularFile::ACTION_CONVERT,
            array(
                'to'     => $format,
                'vcodec' => $vCodec,
                'acodec' => $aCodec,
            ),
            $lowPriority
        );
    }

    /**
     * @param string $format
     * @param bool $lowPriority
     * @param Unistorage $unistorage
     *
     * @return File
     */
    public function extractAudio($format, $lowPriority = false, $unistorage)
    {
        return $unistorage->applyAction(
            $this,
            RegularFile::ACTION_EXTRACT_AUDIO,
            array(
                'to' => $format,
            ),
            $lowPriority
        );
    }

    /**
     * $wmWidth, $wmHeight, $horizontalPadding, $verticalPadding may have following format:
     * <ul>
     * <li> (\d+)px - number calculates in pixels
     * <li> (\d+) - number calculates in percents
     * </ul>
     *
     * @param ImageFile $watermark
     * @param string $wmWidth watermark width
     * @param string $wmHeight watermark height
     * @param string $horizontalPadding padding of watermark
     * @param string $verticalPadding padding of watermark
     * @param string $corner one of ImageFile::CORNER_*
     * @param bool $lowPriority
     * @param Unistorage $unistorage
     *
     * @return File
     */
    public function watermark(
        $watermark,
        $wmWidth,
        $wmHeight,
        $horizontalPadding,
        $verticalPadding,
        $corner,
        $lowPriority = false,
        $unistorage
    ) {
        return $unistorage->applyAction(
            $this,
            RegularFile::ACTION_WATERMARK,
            array(
                'watermark' => $watermark->resourceUri,
                'w'         => $wmWidth,
                'h'         => $wmHeight,
                'w_pad'     => $horizontalPadding,
                'h_pad'     => $verticalPadding,
                'corner'    => $corner,
            ),
            $lowPriority
        );
    }

    /**
     * @param string $format
     * @param integer $position
     * @param bool $lowPriority
     * @param Unistorage $unistorage
     *
     * @return File
     */
    public function captureFrame($format, $position, $lowPriority = false, $unistorage)
    {
        return $unistorage->applyAction(
            $this,
            'capture_frame',
            array(
                'to'       => $format,
                'position' => $position,
            ),
            $lowPriority
        );
    }

    /**
     * @return int
     */
    public function getVideoWidth()
    {
        return $this->videoWidth;
    }

    /**
     * @return int
     */
    public function getVideoHeight()
    {
        return $this->videoHeight;
    }

    /**
     * @return string
     */
    public function getVideoCodec()
    {
        return $this->videoCodec;
    }

    /**
     * @return int
     */
    public function getVideoDuration()
    {
        return $this->videoDuration;
    }

    /**
     * @return int
     */
    public function getVideoBitrate()
    {
        return $this->videoBitrate;
    }

    /**
     * @return int
     */
    public function getVideoFps()
    {
        return $this->videoFps;
    }

    /**
     * @return int
     */
    public function getAudioSampleRate()
    {
        return $this->audioSampleRate;
    }

    /**
     * @return string
     */
    public function getAudioCodec()
    {
        return $this->audioCodec;
    }

    /**
     * @return int
     */
    public function getAudioBitrate()
    {
        return $this->audioBitrate;
    }

    /**
     * @return int
     */
    public function getAudioDuration()
    {
        return $this->audioDuration;
    }

    /**
     * @return int
     */
    public function getAudioChannels()
    {
        return $this->audioChannels;
    }

    /**
     * @return string
     */
    public function getFormat()
    {
        return $this->format;
    }

}
