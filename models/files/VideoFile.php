<?php namespace Unistorage;

/**
 * @property-read int $videoWidth
 * @property-read int $videoHeight
 * @property-read string $videoCodec
 * @property-read int $videoDuration
 * @property-read int $videoBitrate
 * @property-read int $videoFps
 * @property-read int $audioSampleRate
 * @property-read string $audioCodec
 * @property-read int $audioBitrate
 * @property-read int $audioDuration
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
	 * @var int in seconds
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
	 * @var int
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
	 * @var int
	 */
	protected $audioDuration;

	/**
	 * @param string $format
	 * @param string $vCodec
	 * @param string $aCodec
	 * @param Unistorage $unistorage
	 * @return File
	 */
	public function convert($format, $vCodec, $aCodec, $unistorage)
	{
		return $unistorage->applyAction($this, RegularFile::ACTION_CONVERT, array(
			'to' => $format,
			'vcodec' => $vCodec,
			'acodec' => $aCodec,
		));
	}

	/**
	 * @param string $format
	 * @param Unistorage $unistorage
	 * @return File
	 */
	public function extractAudio($format, $unistorage)
	{
		return $unistorage->applyAction($this, RegularFile::ACTION_EXTRACT_AUDIO, array(
			'to' => $format,
		));
	}

	/**
	 * $wmWidth, $wmHeight, $horizontalPadding, $verticalPadding my have following format:
	 * <ul>
	 * <li> (\d+)px - number calculates in pixels
	 * <li> (\d+) - number calculates in percents
	 * </ul>
	 * @param ImageFile $watermark
	 * @param string $wmWidth watermark width
	 * @param string $wmHeight watermark height
	 * @param string $horizontalPadding padding of watermark
	 * @param string $verticalPadding padding of watermark
	 * @param string $corner one of ImageFile::CORNER_*
	 * @param Unistorage $unistorage
	 * @return File
	 */
	public function watermark($watermark, $wmWidth, $wmHeight, $horizontalPadding, $verticalPadding, $corner, $unistorage)
	{
		return $unistorage->applyAction($this, RegularFile::ACTION_WATERMARK, array(
			'watermark' => $watermark->resourceUri,
			'w' => $wmWidth,
			'h' => $wmHeight,
			'w_pad' => $horizontalPadding,
			'h_pad' => $verticalPadding,
			'corner' => $corner,
		));
	}

	/**
	 * @param string $format
	 * @param integer $position
	 * @param Unistorage $unistorage
	 * @return File
	 */
	public function captureFrame($format, $position, $unistorage)
	{
		return $unistorage->applyAction($this, 'capture_frame', array(
			'to' => $format,
			'position' => $position,
		));
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
}
