<?php
include_once '../vendor/autoload.php';

class CasusTest extends PHPUnit_Framework_TestCase
{
	public function testHasMCrypt()
	{
		$casus = new \solidew\Casus\Casus();
		$this->assertEquals(
			function_exists("mcrypt_encrypt"),
			$casus->hasMcrypt()
		);
	}

	public function testHasOpenSSL()
	{
		$casus = new \solidew\Casus\Casus();
		$this->assertEquals(
			function_exists("openssl_random_pseudo_bytes"), 
			$casus->hasOpenSSL()
		);
	}
}