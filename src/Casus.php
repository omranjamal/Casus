<?php
namespace solidew\Casus;

class Casus 
{
	protected $generator;
	protected $secure;

	public function hasMCrypt()
	{
		return function_exists("mcrypt_encrypt");
	}

	public function hasOpenSSL()
	{
		return function_exists("openssl_random_pseudo_bytes");
	}

	public function isSecure()
	{
		return $this->secure;
	}

	public function getDenerator()
	{
		return $this->generator;
	}

	public function __construct($secure = true, Generator $generator = null)
	{
		if ($secure === true && $generator === null) {
			if ($this->hasMCrypt()) {
				$this->generator = new generators\MCrypt;
			} elseif ($this->hasOpenSSL()) {
				$this->generator = new generators\OpenSSL;
			} else {
				throw new errors\Insecure('MCrypt or OpenSSL extension not found');
			}
		} elseif ($generator) {
			$this->generator = $generator;

			if ($secure === true) {
				if ($generator->secure === false) {
					throw new error\Insecure('The provided generator is not a CSPRNG');
				}
			}
		} elseif ($secure === false) {
			$this->generator = new generators\Basic;
		}
	}
}