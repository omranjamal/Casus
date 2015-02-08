<?php
namespace mocks {
    
}

namespace {
    include_once __DIR__.'/../vendor/autoload.php';

    class BasicTest extends PHPUnit_Framework_TestCase
    {
        public function testInteger()
        {
            $min = 3;
            $max = 9;

            $casus = new \solidew\Casus\Basic;
            $val = $casus->integer($min, $max);

            $this->assertTrue($val<=$max && $val>=$min);
            $this->assertInternalType('int', $val);
        }

        public function testFloat()
        {
            $min = 3;
            $max = 9;
            $points = 3;

            $casus = new \solidew\Casus\Basic;
            $val = $casus->float($min, $max, $points);

            $this->assertTrue($val<=$max && $val>=$min);
            $this->assertRegExp('/^[0-9](\.[0-9]{0,3})?$/', (string)$val);
            $this->assertInternalType('float', $val);
        }

        public function testBoolean()
        {
            $casus = new \solidew\Casus\Basic;
            $val = $casus->boolean();

            $this->assertInternalType('boolean', $val);
        }

        public function testAlphaWithNoCaseRandomization()
        {
            $casus = new \solidew\Casus\Basic;
            $val = $casus->alpha(5, false);

            $this->assertEquals(strlen($val), 5);
            $this->assertRegExp('/^[a-z]+$/', (string)$val);
            $this->assertInternalType('string', $val);
        }

        public function testAlphaWithCaseRandomization()
        {
            $casus = new \solidew\Casus\Basic;
            $val = $casus->alpha(200, true);

            $this->assertEquals(strlen($val), 200);
            $this->assertRegExp('/^[a-zA-Z]+$/', (string)$val);
            $this->assertInternalType('string', $val);
        }

        public function testAlphaNumWithNoCaseRandomization()
        {
            $casus = new \solidew\Casus\Basic;
            $val = $casus->alphanum(100, false);

            $this->assertEquals(strlen($val), 100);
            $this->assertRegExp('/^[a-z0-9]+$/', (string)$val);
            $this->assertInternalType('string', $val);
        }

        public function testAlphaNumWithCaseRandomization()
        {
            $casus = new \solidew\Casus\Basic;
            $val = $casus->alphanum(200, true);

            $this->assertEquals(strlen($val), 200);
            $this->assertRegExp('/^[a-zA-Z0-9]+$/', (string)$val);
            $this->assertInternalType('string', $val);
        }

        public function testAsciiRangeNested()
        {
            $casus = new \solidew\Casus\Basic;
            $val = $casus->asciiRange(200, [[97,97]]);

            $this->assertEquals(strlen($val), 200);
            $this->assertRegExp('/^a+$/', $val);
            $this->assertInternalType('string', $val);

            $val = $casus->asciiRange(200, [[97,98]]);
            $this->assertRegExp('/^[ab]+$/', $val);
            $this->assertInternalType('string', $val);
        }

        public function testAsciiRangeFlat()
        {
            $casus = new \solidew\Casus\Basic;
            $val = $casus->asciiRange(200, [97,97]);

            $this->assertEquals(strlen($val), 200);
            $this->assertRegExp('/^a+$/', $val);
            $this->assertInternalType('string', $val);

            $val = $casus->asciiRange(200, [97,98]);
            $this->assertRegExp('/^[ab]+$/', $val);
            $this->assertInternalType('string', $val);
        }

        /**
         * @expectedException \solidew\Casus\errors\InvalidRange
         */
        public function testAsciiRangeInvalidRange()
        {
            $casus = new \solidew\Casus\Basic;
            $val = $casus->asciiRange(200, 'haha');
        }

        /**
         * @expectedException \solidew\Casus\errors\InvalidRange
         */
        public function testAsciiRangeNoRange()
        {
            $casus = new \solidew\Casus\Basic;
            $val = $casus->asciiRange(200, []);
        }

        public function testString()
        {
            $casus = new \solidew\Casus\Basic;
            $val = $casus->string(40, $charset = 'a');

            $this->assertEquals(strlen($val), 40);
            $this->assertRegExp('/^a+$/', $val);
            $this->assertInternalType('string', $val);

            $val = $casus->string(40, $charset = ['b']);

            $this->assertEquals(strlen($val), 40);
            $this->assertRegExp('/^b+$/', $val);
            $this->assertInternalType('string', $val);
        }

        public function testIntegerArray()
        {
            $casus = new \solidew\Casus\Basic;
            $val = $casus->integerArray(1,2,100);
            $this->assertInternalType('array', $val);
            $this->assertEquals(count($val), 100);
            $this->assertContainsOnly('int', $val);
        }

        public function testFloatArray()
        {
            $casus = new \solidew\Casus\Basic;
            $val = $casus->floatArray(1,2,4,100);
            $this->assertInternalType('array', $val);
            $this->assertEquals(count($val), 100);
            $this->assertContainsOnly('float', $val);
        }
    }
}