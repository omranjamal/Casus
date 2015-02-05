<?php
namespace solidew\Casus\generators;

class MCrypt extends \solidew\Casus\Generator 
{
	protected $secure = true;

	private $bytes = 0;
	private $signed;
	
	public function __construct($bytes = PHP_INT_SIZE, $signed = true)
	{
		if ($bytes > PHP_INT_SIZE) {
			throw new \solidew\Casus\errors\ByteOverflow(
				'Your Version of PHP dosen\'t support that many bytes'
			);
		} else {
			$this->bytes = $bytes;
		}

		$this->signed = $signed;
	}

	public function generate()
	{
		$raw = mcrypt_create_iv($this->bytes, MCRYPT_DEV_URANDOM);
		$num = 0;
		for ($i=0; $i<$this->bytes; $i++) {
			$num = ($num<<8)|ord($raw[$i]);
		}

		if ($this->signed === true || $this->bytes === PHP_INT_SIZE) {
			$num = $num&(~(1<<($this->bytes*8-1)));
		}
	}
}