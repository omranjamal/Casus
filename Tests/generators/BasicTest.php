<?php
namespace mocks {
	
}

namespace {
	include_once __DIR__.'/../../vendor/autoload.php';

	class BasicTest extends PHPUnit_Framework_TestCase
	{
		public function testMax()
		{
			$basic = new \solidew\Casus\generators\Basic();
			$this->assertEquals(
				decbin($basic->getMax()),
				decbin(PHP_INT_MAX)
			);

			$basic = new \solidew\Casus\generators\Basic(1);
			$this->assertEquals(
				decbin($basic->getMax()),
				decbin(127)
			);

			$basic = new \solidew\Casus\generators\Basic(1, false);
			$this->assertEquals(
				decbin($basic->getMax()),
				decbin(255)
			);

			$basic = new \solidew\Casus\generators\Basic(2, false);
			$this->assertEquals(
				decbin($basic->getMax()),
				'1111111111111111'
			);

			$basic = new \solidew\Casus\generators\Basic(2, true);
			$this->assertEquals(
				decbin($basic->getMax()),
				'111111111111111'
			);
		}

		/**
	     * @expectedException \solidew\Casus\errors\ByteOverflow
	     */
		public function testByteOverflow()
		{
			$basic = new \solidew\Casus\generators\Basic(9);
		}
	}
}