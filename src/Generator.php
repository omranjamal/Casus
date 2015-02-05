<?php
namespace \solidew\Casus;

abstract class Generator
{
	protected $secure = false;

	public function isSecure()
	{
		return $this->secure;
	}

	abstract public function generate();
}