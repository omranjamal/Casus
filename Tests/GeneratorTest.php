<?php
namespace mocks {
    class Generator extends \solidew\Casus\Basic
    {
    }
}

namespace {
    include_once __DIR__.'/../vendor/autoload.php';

    class GeneratorTest extends PHPUnit_Framework_TestCase
    {
        public $casus = null;

        public function setUp() {
            $this->casus = new mocks\Generator();
        }

        public function tearDown() {
            $this->casus = null;
        }

        public function testInteger()
        {
            $min = 3;
            $max = 9;

            $casus = $this->casus;
            $val = $casus->integer($min, $max);

            $this->assertTrue($val<=$max && $val>=$min);
            $this->assertInternalType('int', $val);
        }

        public function testFloat()
        {
            $min = 3;
            $max = 9;
            $points = 3;

            $casus = $this->casus;
            $val = $casus->float($min, $max, $points);

            $this->assertTrue($val<=$max && $val>=$min);
            $this->assertRegExp('/^[0-9](\.[0-9]{0,3})?$/', (string)$val);
            $this->assertInternalType('float', $val);
        }

        public function testFloatWithNegativePrecision()
        {
            $min = 3;
            $max = 9;
            $points = -3;

            $casus = $this->casus;
            $val = $casus->float($min, $max, $points);

            $this->assertTrue($val<=$max && $val>=$min);
            $this->assertRegExp('/^[0-9](\.[0-9]{0,3})?$/', (string)$val);
            $this->assertInternalType('float', $val);
        }

        public function testBoolean()
        {
            $casus = $this->casus;
            $val = $casus->boolean();

            $this->assertInternalType('boolean', $val);
        }

        public function testAlphaWithNoCaseRandomization()
        {
            $casus = $this->casus;
            $val = $casus->alpha(5, false);

            $this->assertEquals(strlen($val), 5);
            $this->assertRegExp('/^[a-z]+$/', (string)$val);
            $this->assertInternalType('string', $val);
        }

        public function testAlphaWithCaseRandomization()
        {
            $casus = $this->casus;
            $val = $casus->alpha(200, true);

            $this->assertEquals(strlen($val), 200);
            $this->assertRegExp('/^[a-zA-Z]+$/', (string)$val);
            $this->assertInternalType('string', $val);
        }

        public function testAlphaWithNegativeLength()
        {
            $casus = $this->casus;
            $val = $casus->alpha(-200, true);

            $this->assertEquals(strlen($val), 200);
            $this->assertRegExp('/^[a-zA-Z]+$/', (string)$val);
            $this->assertInternalType('string', $val);
        }

        public function testAlphaNumWithNoCaseRandomization()
        {
            $casus = $this->casus;
            $val = $casus->alphanum(100, false);

            $this->assertEquals(strlen($val), 100);
            $this->assertRegExp('/^[a-z0-9]+$/', (string)$val);
            $this->assertInternalType('string', $val);
        }

        public function testAlphaNumWithCaseRandomization()
        {
            $casus = $this->casus;
            $val = $casus->alphanum(200, true);

            $this->assertEquals(strlen($val), 200);
            $this->assertRegExp('/^[a-zA-Z0-9]+$/', (string)$val);
            $this->assertInternalType('string', $val);
        }

        public function testAlphaNumWithNegativeLength()
        {
            $casus = $this->casus;
            $val = $casus->alphanum(-200, true);

            $this->assertEquals(strlen($val), 200);
            $this->assertRegExp('/^[a-zA-Z0-9]+$/', (string)$val);
            $this->assertInternalType('string', $val);
        }

        public function testAsciiRangeNested()
        {
            $casus = $this->casus;
            $val = $casus->asciiRange(200, [[97,97]]);

            $this->assertEquals(strlen($val), 200);
            $this->assertRegExp('/^a+$/', $val);
            $this->assertInternalType('string', $val);

            $val = $casus->asciiRange(200, [[97,98],[99,100]]);
            $this->assertRegExp('/^[abcd]+$/', $val);
            $this->assertInternalType('string', $val);
        }

        public function testAsciiRangeNestedWithNegativeLength()
        {
            $casus = $this->casus;
            $val = $casus->asciiRange(-200, [[97,97]]);

            $this->assertEquals(strlen($val), 200);
            $this->assertRegExp('/^a+$/', $val);
            $this->assertInternalType('string', $val);
        }

        public function testAsciiRangeFlat()
        {
            $casus = $this->casus;
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
            $casus = $this->casus;
            $val = $casus->asciiRange(200, 'haha');
        }

        /**
         * @expectedException \solidew\Casus\errors\InvalidRange
         */
        public function testAsciiRangeNoRange()
        {
            $casus = $this->casus;
            $val = $casus->asciiRange(200, []);
        }

        public function testString()
        {
            $casus = $this->casus;
            $val = $casus->string(40, $charset = 'a');

            $this->assertEquals(strlen($val), 40);
            $this->assertRegExp('/^a+$/', $val);
            $this->assertInternalType('string', $val);

            $val = $casus->string(40, $charset = ['b']);

            $this->assertEquals(strlen($val), 40);
            $this->assertRegExp('/^b+$/', $val);
            $this->assertInternalType('string', $val);
        }

        public function testStringWithNegativeLength()
        {
            $casus = $this->casus;
            $val = $casus->string(-40, $charset = 'a');

            $this->assertEquals(strlen($val), 40);
            $this->assertRegExp('/^a+$/', $val);
            $this->assertInternalType('string', $val);
        }

        public function testIntegerArray()
        {
            $casus = $this->casus;
            $val = $casus->integerArray(1,2,100);
            $this->assertInternalType('array', $val);
            $this->assertEquals(count($val), 100);
            $this->assertContainsOnly('int', $val);
        }

        public function testIntegerArrayWithNegativeLength()
        {
            $casus = $this->casus;
            $val = $casus->integerArray(1,2,-100);
            $this->assertInternalType('array', $val);
            $this->assertEquals(count($val), 100);
            $this->assertContainsOnly('int', $val);
        }

        public function testFloatArray()
        {
            $casus = $this->casus;
            $val = $casus->floatArray(1,2,4,100);
            $this->assertInternalType('array', $val);
            $this->assertEquals(count($val), 100);
            $this->assertContainsOnly('float', $val);
        }

        public function testFloatArrayWithNegativeLength()
        {
            $casus = $this->casus;
            $val = $casus->floatArray(1,2,4,-100);
            $this->assertInternalType('array', $val);
            $this->assertEquals(count($val), 100);
            $this->assertContainsOnly('float', $val);
        }

        public function testRandomizeWithString()
        {
            $casus = $this->casus;
            $val = $casus->randomize('Potato');

            $this->assertInternalType('string', $val);
            $this->assertEquals(strlen($val), 6);
            $this->assertTrue(in_array('P',str_split($val)));
        }

        public function testRandomizeWithArray()
        {
            $casus = $this->casus;
            $val = $casus->randomize(['P','o','t','a','t','o']);

            $this->assertInternalType('array', $val);
            $this->assertEquals(count($val), 6);
            $this->assertTrue(in_array('P', $val));
        }

        public function selectRandomWithString()
        {
            $casus = $this->casus;
            $val = $casus->selectRandom('Potato', 3);

            $this->assertInternalType('string', $val);
            $this->assertEquals(strlen($val), 3);
            $this->assertTrue(in_array(['P','o','t','a'],str_split($val)));
        }

        public function selectRandomWithArray()
        {
            $casus = $this->casus;
            $val = $casus->selectRandom(['P','o','t','a','t','o'], 3);

            $this->assertInternalType('array', $val);
            $this->assertEquals(count($val), 3);
            $this->assertTrue(in_array(['P','o','t','a'], $val));
        }

        public function selectRandomWithLengthBiggerThanInput()
        {
            $casus = $this->casus;
            $val = $casus->selectRandom(['P','o','t','a','t','o'], 20);

            $this->assertInternalType('array', $val);
            $this->assertEquals(count($val), 6);
            $this->assertTrue(in_array(['P','o','t','a'], $val));
        }

        public function selectRandomWithNegativeLength()
        {
            $casus = $this->casus;
            $val = $casus->selectRandom(['P','o','t','a','t','o'], -20);

            $this->assertInternalType('array', $val);
            $this->assertEquals(count($val), 6);
            $this->assertTrue(in_array(['P','o','t','a'], $val));
        }
    }
}