<?php
namespace hedronium\Casus;

class OpenSSL extends Generator
{
	protected $secure = true;

	public function integer($min = 0, $max = PHP_INT_MAX)
	{
		$bytes = openssl_random_pseudo_bytes(PHP_INT_SIZE);
		$num = 0;

		for ($i = 0; $i < PHP_INT_SIZE; $i++) {
			$num = ($num<<8)|ord($bytes[$i]);
		}

		if ($min>=0 && $max>=0) {
			$num = abs($num);
		}

		return $min+($num%($max-$min+1));
	}

	public function byte($secure = true)
	{
		return openssl_random_pseudo_bytes(1);
	}

	public function byteString($length = 32, $secure = true)
	{
		return openssl_random_pseudo_bytes($length);
	}

	public function __construct()
	{
		$is_secure = false;
		openssl_random_pseudo_bytes(1, $is_secure);

		$this->secure = $is_secure;
	}
}
