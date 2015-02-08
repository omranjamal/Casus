<?php
include_once __DIR__.'/../vendor/autoload.php';
include_once __DIR__.'/GeneratorTest.php';

class MCryptTest extends \GeneratorTest
{
	public function setUp() {
        $this->casus = new \solidew\Casus\MCrypt();
    }

    public function tearDown() {
        $this->casus = null;
    }
}