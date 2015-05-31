<?php namespace Jlem\Enum\Tests;

use Jlem\Enum\Tests\Fixtures\NumericFixture;


/**
 * This tests all class methods of a given enumeration class
 */

class NumericClassTest extends \PHPUnit_Framework_Testcase
{
    public function testBasicConstants()
    {
        $this->assertSame(1, NumericFixture::HAN);
        $this->assertSame(2, NumericFixture::LUKE);
        $this->assertSame(3, NumericFixture::VADER);
    }

    public function testConstantsReturnsArrayKeyedByConstants()
    {
        $expected = array(
            'HAN' => 1,
            'LUKE' => 2,
            'VADER' => 3
        );

        $actual = NumericFixture::constants();

        $this->assertSame($expected, $actual);
    }

    public function testFullArray()
    {
        $expected = array(
            array(
                'key' => 'HAN',
                'string' => 'Han Solo',
                'value' => 1,
                'instance' => NumericFixture::HAN()
            ),
            array(
                'key' => 'LUKE',
                'string' => 'Luke Skywalker',
                'value' => 2,
                'instance' => NumericFixture::LUKE()
            ),
            array(
                'key' => 'VADER',
                'string' => 'Darth Vader',
                'value' => 3,
                'instance' => NumericFixture::VADER()
            )
        );

        $actual = NumericFixture::fullArray();

        $this->assertEquals($expected, $actual);
    }


    public function testArrayOfValueKeyCombo()
    {
        $expected = array(
            'HAN' => 1,
            'LUKE' => 2,
            'VADER' => 3
        );

        $actual = NumericFixture::arrayOf('value', 'key');

        $this->assertSame($expected, $actual);
    }

    public function testArrayOfKeyValueCombo()
    {
        $expected = array(
            1 => 'HAN',
            2 => 'LUKE',
            3 => 'VADER'
        );

        $actual = NumericFixture::arrayOf('key', 'value');

        $this->assertSame($expected, $actual);
    }

    public function testArrayOfStringKeyCombo()
    {
        $expected = array(
            'HAN' => 'Han Solo',
            'LUKE' => 'Luke Skywalker',
            'VADER' => 'Darth Vader'
        );

        $actual = NumericFixture::arrayOf('string', 'key');

        $this->assertSame($expected, $actual);
    }

    public function testArrayOfKeyStringCombo()
    {
        $expected = array(
            'Han Solo' => 'HAN',
            'Luke Skywalker' => 'LUKE',
            'Darth Vader' => 'VADER'
        );

        $actual = NumericFixture::arrayOf('key', 'string');

        $this->assertSame($expected, $actual);
    }

    public function testArrayOfValueStringCombo()
    {
        $expected = array(
            'Han Solo' => 1,
            'Luke Skywalker' => 2,
            'Darth Vader' => 3
        );

        $actual = NumericFixture::arrayOf('value', 'string');

        $this->assertSame($expected, $actual);
    }

    public function testArrayOfStringValueCombo()
    {
        $expected = array(
            1 => 'Han Solo',
            2 => 'Luke Skywalker',
            3 => 'Darth Vader'
        );

        $actual = NumericFixture::arrayOf('string', 'value');

        $this->assertSame($expected, $actual);
    }

    public function testArrayOfInstancesValueCombo()
    {
        $expected = array(
            1 => NumericFixture::HAN(),
            2 => NumericFixture::LUKE(),
            3 => NumericFixture::VADER()
        );

        $actual = NumericFixture::arrayOf('instance', 'value');

        $this->assertEquals($expected, $actual);
    }

    public function testArrayOfInstancesKeyCombo()
    {
        $expected = array(
            'HAN' => NumericFixture::HAN(),
            'LUKE' => NumericFixture::LUKE(),
            'VADER' => NumericFixture::VADER()
        );

        $actual = NumericFixture::arrayOf('instance', 'key');

        $this->assertEquals($expected, $actual);
    }

    public function testArrayOfInstanceStringCombo()
    {
        $expected = array(
            'Han Solo' => NumericFixture::HAN(),
            'Luke Skywalker' => NumericFixture::LUKE(),
            'Darth Vader' => NumericFixture::VADER()
        );

        $actual = NumericFixture::arrayOf('instance', 'string');

        $this->assertEquals($expected, $actual);
    }
}
