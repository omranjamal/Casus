<?php
namespace solidew\Casus\generators;

class Basic extends \solidew\Casus\Generator 
{
	protected $max = 0;
	protected $min = 0;

	public function getMax(){
		return $this->max;
	}

	public function __construct($bytes = PHP_INT_SIZE, $signed = true)
	{
		if ($bytes > PHP_INT_SIZE) {
			throw new \solidew\Casus\errors\ByteOverflow(
				'Your Version of PHP dosen\'t support that many bytes'
			);
		} elseif ($bytes !== PHP_INT_SIZE) {
			$bits = $bytes*8;
			$i = 0;

			$signed = (int) $signed;

			while ($i < ($bits-$signed)) {
				$this->max = ($this->max<<1)|1;
				$i++;
			}
		} else {
			$this->max = PHP_INT_MAX;
		}
	}

	public function generate()
	{
		return mt_rand($this->min, $this->max);
	}
}