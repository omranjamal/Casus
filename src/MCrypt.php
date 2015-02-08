<?php
namespace solidew\Casus;

class MCrypt extends Generator 
{
    protected $secure = true;
	
	public function integer($min = 0, $max = PHP_INT_MAX)
	{
		$bytes = mcrypt_create_iv(PHP_INT_SIZE, MCRYPT_DEV_URANDOM);
		$num = 0;

		for ($i = 0; $i < PHP_INT_SIZE; $i++) {
			$num = ($num<<8)|ord($bytes[$i]);
		}

		if ($min>=0 && $max>=0) {
			$num = abs($num);
		}

		return $min+($num%($max-$min+1));
	}
}