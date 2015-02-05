<?php
namespace mocks {
	class noMCrypt extends \solidew\Casus\Casus
	{
		public function hasMCrypt()
		{
			return false;
		}
	}

	class noOpenSSL extends \solidew\Casus\Casus
	{
		public function hasOpenSSL()
		{
			return false;
		}
	}

	class noSecureAlgo extends \solidew\Casus\Casus
	{
		public function hasMCrypt()
		{
			return false;
		}

		public function hasOpenSSL()
		{
			return false;
		}
	}
}

namespace {
	include_once __DIR__.'/../vendor/autoload.php';

	class CasusTest extends PHPUnit_Framework_TestCase
	{
		public function testHasMCrypt()
		{
			$casus = new \solidew\Casus\Casus();
			$casus->setGenerator();
			$this->assertEquals(
				function_exists("mcrypt_encrypt"),
				$casus->hasMcrypt()
			);
		}

		public function testHasOpenSSL()
		{
			$casus = new \solidew\Casus\Casus();
			$casus->setGenerator();
			$this->assertEquals(
				function_exists("openssl_random_pseudo_bytes"), 
				$casus->hasOpenSSL()
			);
		}

		public function testDefaultConstruction()
		{
			//With Default Values
			$casus = new \solidew\Casus\Casus();
			$casus->setGenerator();
			
			if ($casus->hasMCrypt()) {
				$this->assertInstanceOf(
					'\\solidew\\Casus\\generators\\MCrypt',
					$casus->getGenerator()
				);
			} elseif ($casus->hasOpenSSL()) {
				$this->assertInstanceOf(
					'\\solidew\\Casus\\generators\\OpenSSL',
					$casus->getGenerator()
				);
			}
		}

		public function testExplicitValueSettings()
		{
			//With one value explicitly set
			$casus = new \solidew\Casus\Casus();
			$casus->setGenerator(true);
			
			if ($casus->hasMCrypt()) {
				$this->assertInstanceOf(
					'\\solidew\\Casus\\generators\\MCrypt',
					$casus->getGenerator()
				);
			} elseif ($casus->hasOpenSSL()) {
				$this->assertInstanceOf(
					'\\solidew\\Casus\\generators\\OpenSSL',
					$casus->getGenerator()
				);
			}



			//With both values explicitly set
			$casus = new \solidew\Casus\Casus(true, null);

			if ($casus->hasMCrypt()) {
				$this->assertInstanceOf(
					'\\solidew\\Casus\\generators\\MCrypt',
					$casus->getGenerator()
				);
			} elseif ($casus->hasOpenSSL()) {
				$this->assertInstanceOf(
					'\\solidew\\Casus\\generators\\OpenSSL',
					$casus->getGenerator()
				);
			}
		}

		public function testConstructionWithoutMCrypt()
		{
			//Without MCrypt
			$casus = new \mocks\noMCrypt(true, null);

			$this->assertInstanceOf(
				'\\solidew\\Casus\\generators\\OpenSSL',
				$casus->getGenerator()
			);
		}

		public function testConstructionWithoutOpenSSL()
		{
			//Without OpenSSL
			$casus = new \mocks\noOpenSSL(true, null);

			$this->assertInstanceOf(
				'\\solidew\\Casus\\generators\\MCrypt',
				$casus->getGenerator()
			);
		}

		/**
	     * @expectedException \solidew\Casus\errors\Insecure
	     */
		public function testConstructionWithoutAnySecureExtension()
		{
			//Without any secure extension
			$casus = new \mocks\noSecureAlgo(true, null);
		}

		public function testSetGenerator()
		{
			$generator = new \solidew\Casus\generators\MCrypt();
			$casus = new \solidew\Casus\Casus(true, $generator);
			$this->assertEquals($generator, $casus->getGenerator());

			$generator = new \solidew\Casus\generators\OpenSSL();
			$casus = new \solidew\Casus\Casus(true, $generator);
			$this->assertEquals($generator, $casus->getGenerator());
		}

		/**
	     * @expectedException \solidew\Casus\errors\Insecure
	     */
		public function testInsecureGeneratorException()
		{
			$generator = new \solidew\Casus\generators\Basic();
			$casus = new \solidew\Casus\Casus(true, $generator);
		}

		public function testSetBasicGenerator()
		{
			$generator = new \solidew\Casus\generators\Basic();
			$casus = new \solidew\Casus\Casus(false, $generator);
			$this->assertEquals($generator, $casus->getGenerator());
		}

		public function testDefaultBasicGenerator()
		{
			$casus = new \solidew\Casus\Casus(false);

			$this->assertInstanceOf(
				'\\solidew\\Casus\\generators\\Basic',
				$casus->getGenerator()
			);
		}
	}
}