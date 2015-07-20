<?php
namespace mocks {
    class noMCrypt extends \hedronium\Casus\Casus
    {
        public function hasMCrypt()
        {
            return false;
        }
    }

    class noOpenSSL extends \hedronium\Casus\Casus
    {
        public function hasOpenSSL()
        {
            return false;
        }
    }

    class noSecureAlgo extends \hedronium\Casus\Casus
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

    class magic extends \hedronium\Casus\MCrypt
    {
        public function magicAintReal($name)
        {
            return 'WORD. '.$name;
        }
    }
}

namespace {
    include_once __DIR__.'/../vendor/autoload.php';

    class CasusTest extends PHPUnit_Framework_TestCase
    {
        public function testHasMCrypt()
        {
            $casus = new \hedronium\Casus\Casus();
            $casus->setGenerator();
            $this->assertEquals(
                function_exists("mcrypt_encrypt"),
                $casus->hasMcrypt()
            );
        }

        public function testHasOpenSSL()
        {
            $casus = new \hedronium\Casus\Casus();
            $casus->setGenerator();
            $this->assertEquals(
                function_exists("openssl_random_pseudo_bytes"), 
                $casus->hasOpenSSL()
            );
        }

        public function testDefaultConstruction()
        {
            //With Default Values
            $casus = new \hedronium\Casus\Casus();
            $casus->setGenerator();
            
            if ($casus->hasMCrypt()) {
                $this->assertInstanceOf(
                    '\\hedronium\\Casus\\MCrypt',
                    $casus->getGenerator()
                );
            } elseif ($casus->hasOpenSSL()) {
                $this->assertInstanceOf(
                    '\\hedronium\\Casus\\OpenSSL',
                    $casus->getGenerator()
                );
            }
        }

        public function testExplicitValueSettings()
        {
            //With one value explicitly set
            $casus = new \hedronium\Casus\Casus();
            $casus->setGenerator(true);
            
            if ($casus->hasMCrypt()) {
                $this->assertInstanceOf(
                    '\\hedronium\\Casus\\MCrypt',
                    $casus->getGenerator()
                );
                $secure = true;
            } elseif ($casus->hasOpenSSL()) {
                $this->assertInstanceOf(
                    '\\hedronium\\Casus\\OpenSSL',
                    $casus->getGenerator()
                );
                $secure = true;
            }

            $this->assertTrue($secure);



            //With both values explicitly set
            $casus = new \hedronium\Casus\Casus(true, null);

            if ($casus->hasMCrypt()) {
                $this->assertInstanceOf(
                    '\\hedronium\\Casus\\MCrypt',
                    $casus->getGenerator()
                );
            } elseif ($casus->hasOpenSSL()) {
                $this->assertInstanceOf(
                    '\\hedronium\\Casus\\OpenSSL',
                    $casus->getGenerator()
                );
            }
        }

        public function testConstructionWithoutMCrypt()
        {
            //Without MCrypt
            $casus = new \mocks\noMCrypt(true, null);

            $this->assertInstanceOf(
                '\\hedronium\\Casus\\OpenSSL',
                $casus->getGenerator()
            );
        }

        public function testConstructionWithoutOpenSSL()
        {
            //Without OpenSSL
            $casus = new \mocks\noOpenSSL(true, null);

            $this->assertInstanceOf(
                '\\hedronium\\Casus\\MCrypt',
                $casus->getGenerator()
            );
        }

        /**
         * @expectedException \hedronium\Casus\errors\Insecure
         */
        public function testConstructionWithoutAnySecureExtension()
        {
            //Without any secure extension
            $casus = new \mocks\noSecureAlgo(true, null);
        }

        public function testSetGenerator()
        {
            $generator = new \hedronium\Casus\MCrypt();
            $casus = new \hedronium\Casus\Casus(true, $generator);
            $this->assertEquals($generator, $casus->getGenerator());

            $generator = new \hedronium\Casus\OpenSSL();
            $casus = new \hedronium\Casus\Casus(true, $generator);
            $this->assertEquals($generator, $casus->getGenerator());
        }

        /**
         * @expectedException \hedronium\Casus\errors\Insecure
         */
        public function testInsecureGeneratorException()
        {
            $generator = new \hedronium\Casus\Basic();
            $casus = new \hedronium\Casus\Casus(true, $generator);
        }

        public function testSetBasicGenerator()
        {
            $generator = new \hedronium\Casus\Basic();
            $casus = new \hedronium\Casus\Casus(false, $generator);
            $this->assertEquals($generator, $casus->getGenerator());
        }

        public function testDefaultBasicGenerator()
        {
            $casus = new \hedronium\Casus\Casus(false);

            $this->assertInstanceOf(
                '\\hedronium\\Casus\\Basic',
                $casus->getGenerator()
            );
        }

        public function testInvoke()
        {
            $casus = new \hedronium\Casus\Casus(false);
            $val = $casus(4,10);
            $this->assertInternalType('int', $val);
            $this->assertTrue($val<=10 && $val>=4);
        }

        public function testMagicalCalls()
        {
            $casus = new \hedronium\Casus\Casus(false, (new \mocks\magic));
            $val = $casus->magicAintReal('Nigga.');
            $this->assertInternalType('string', $val);
            $this->assertEquals('WORD. Nigga.', $val);
        }
    }
}