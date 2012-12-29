<?php namespace Unistorage\Models;

use Unistorage\USException;

class Component
{
	public function __get($name)
	{
		$getter='get'.$name;
		if(method_exists($this,$getter))
			return $this->$getter();

		throw new USException("Property '".get_class($this).".$name' is not defined.");
	}
}
