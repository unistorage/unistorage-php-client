<?php namespace Unistorage;

defined('UNISTORAGE_CLIENT') || define('UNISTORAGE_CLIENT', __DIR__);

require_once(__DIR__.'/autoload.php');

class Unistorage
{
	const STATUS_OK = 'ok';
	const STATUS_ERROR = 'error';
	const STATUS_WAIT = 'wait';
	const STATUS_JUST_URI = 'just_uri';

	/**
	 * @var string Unistorage host
	 */
	public $host;

	/**
	 * @var string Unistorage access token
	 */
	public $token;

	/**
	 * @param string $endPoint
	 * @param array $fields
	 * @param string $method post or get
	 * @throws USException
	 * @return array unistorage response in array format
	 */
	private function sendRequest($endPoint, $fields = array(), $method = 'get')
	{
		$tokenHeader = array(
			CURLOPT_HTTPHEADER => array(
				'Token: '.$this->token,
			),
		);
		if ($method == 'get')
			$returnedData = \CurlHelper::getUrl($this->host.$endPoint.(!empty($fields) ? '?'.http_build_query($fields) : ''), $tokenHeader);
		else
			$returnedData = \CurlHelper::postUrl($this->host.$endPoint, $fields, $tokenHeader);
		$answer = json_decode($returnedData, true);
		if (is_null($answer))
			throw new USException('answer from unistorage can\'t be decoded: '.$returnedData);

		if (empty($answer['status']))
			throw new USException('answer from unistorage have missing status field: '.$returnedData);
		if ($answer['status'] == self::STATUS_ERROR) {
			if (empty($answer['msg']))
				throw new USException('answer from unistorage have missing msg field: '.$returnedData);
			throw new USException('unistorage error: '.$answer['msg']);
		}

		return $answer;
	}

	/**
	 * @param string $filePath
	 * @param string $filename
	 * @param null|string $typeId used for internal unistorage statistics
	 * @return File
	 */
	public function uploadFile($filePath, $filename='', $typeId = null)
	{
		if (empty($filename))
			$filename = pathinfo($filePath, PATHINFO_BASENAME);

		$fields = array('file' => "@$filePath;filename=$filename");
		if (!is_null($typeId)) {
			$fields+= array('type_id' => $typeId);
		}
		$answer = $this->sendRequest('/', $fields, 'post');

		return $this->getFile( $answer['resource_uri'] );
	}

	protected function getFilesNamespace() {
		return '\\Unistorage\\';
	}

	/**
	 * @param string $resourceUri
	 * @throws USException
	 * @return File
	 */
	public function getFile($resourceUri)
	{
		$answer = $this->sendRequest($resourceUri);
		if ($answer['status'] == self::STATUS_WAIT) {
			return new PendingFile($resourceUri, $answer['ttl']);
		} elseif (strpos($resourceUri, '/zip/') === 0) {
			return new ZipFile($answer['data']['url'], $resourceUri, $answer['ttl']);
		} elseif ($answer['status'] == self::STATUS_JUST_URI) {
			return new TemporaryFile($answer['data']['url'], $resourceUri, $answer['ttl']);
		} else {
			static $unistorageTypeToClassName = array(
				'image' => 'ImageFile',
				'video' => 'VideoFile',
				'audio' => 'AudioFile',
				'doc' => 'DocFile',
				'unknown' => 'RegularFile',
			);

			$className = $unistorageTypeToClassName[ $answer['data']['unistorage_type'] ];

			$className = $this->getFilesNamespace().$className;
			$properties = $this->convertToFieldNames($answer['data']);

			return new $className($properties, $resourceUri, $answer['ttl']);
		}
	}

	/**
	 * @param array $answerData
	 * @return array
	 */
	private function convertToFieldNames($answerData)
	{
		$answerData['mimeType'] = $answerData['mimetype'];
		unset($answerData['mimetype']);

		$answerData['unistorageType'] = $answerData['unistorage_type'];
		unset($answerData['unistorageType']);

		foreach ($answerData['extra'] as $id => $value) {
			if (is_array($value)) {
				foreach ($value as $id2 => $value2) {
					$answerData[$this->normalizeFieldName($id.'_'.$id2)] = $value2;
				}
			} else {
				$answerData[$this->normalizeFieldName($id)] = $value;
			}
		}
		unset($answerData['extra']);

		return $answerData;
	}

	/**
	 * convert sample_name to sampleName (underscore style to camelCase style)
	 * @param string $name
	 * @return string
	 */
	private function normalizeFieldName($name)
	{
		return preg_replace_callback('#_(.)#', function($matches) {
			return strtoupper($matches[1]);
		}, $name);
	}

	/**
	 * @param array $actions array( actionName => array with action params)
	 * @param string $applicableFor file unistorageType. One of RegularFile::FILE_TYPE_*
	 * @throws USException
	 * @return Template
	 */
	public function createTemplate($actions, $applicableFor)
	{
		$postQuery = http_build_query(array(
			'applicable_for' => $applicableFor,
		));
		foreach ($actions as $action => $params) {
			$postQuery.= '&action[]='.urlencode(http_build_query(array('action' => $action) + $params));
		}

		$answer = $this->sendRequest('/template/', $postQuery, 'post');

		return new Template($answer['resource_uri']);
	}

	/**
	 * @param RegularFile $file
	 * @param string $actionName
	 * @param array $actionParams
	 * @throws USException
	 * @return File
	 */
	public function applyAction($file, $actionName, $actionParams = array())
	{
		$answer = $this->sendRequest($file->resourceUri, array(
			'action' => $actionName,
		) + $actionParams);

		return $this->getFile( $answer['resource_uri'] );
	}

	/**
	 * @param RegularFile $file
	 * @param Template $template
	 * @throws USException
	 * @return File
	 */
	public function applyTemplate($file, $template)
	{
		$answer = $this->sendRequest($file->resourceUri, array(
			'template' => $template->resourceUri,
		));

		return $this->getFile( $answer['resource_uri'] );
	}

	/**
	 * @param RegularFile[] $files
	 * @param string $zipFileName
	 * @throws USException
	 * @return ZipFile
	 */
	public function getZipped($files, $zipFileName)
	{
		$postQuery = http_build_query(array(
			'filename' => $zipFileName,
		));
		foreach ($files as $file) {
			$postQuery.= '&file[]='.urlencode($file->resourceUri);
		}

		$answer = $this->sendRequest('/zip/', $postQuery, 'post');

		return $this->getFile( $answer['resource_uri'] );
	}
}

class USException extends \Exception {}
