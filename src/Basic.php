<?php
namespace solidew\Casus;

class Basic extends \solidew\Casus\Generator 
{
	public function integer($min = 0, $max = PHP_INT_MAX)
    {
        return mt_rand($min, $max);
    }
}