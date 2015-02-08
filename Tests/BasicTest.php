<?php
include_once __DIR__.'/../vendor/autoload.php';
include_once __DIR__.'/GeneratorTest.php';

class BasicTest extends \GeneratorTest
{
    public function setUp() {
        $this->casus = new \solidew\Casus\Basic();
    }
}