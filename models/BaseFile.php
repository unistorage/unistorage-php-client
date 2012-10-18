<?php

class BaseFile
{
	private $uid;
	private $created;
	private $ttl;
	private $uri;
	private $name;
	private $size;

	public function __construct($uid, $info, $ttl)
	{
		$this->created = time();
		$this->ttl = $ttl;
		$this->uid = $uid;

		if ($info) {
			$this->uri = $info->uri;
			$this->size = $info->size;
			$this->name = $info->name;
		}
	}

	/**
	 * @return int Time left to live
	 */
	public function getExpire()
	{
		$expire = time() - $this->created - $this->ttl;

		return $expire < 0 ? 0 : $expire;
	}

	public function getUid()
	{
		return $this->uid;
	}

	public function getName()
	{
		return $this->name;
	}

	public function getSize()
	{
		return $this->size;
	}

	public function getUri()
	{
		return $this->uri;
	}
}
