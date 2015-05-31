<?php namespace Jlem\Enum\Tests;

class EnumerationNumericTest extends \PHPUnit_Framework_TestCase
{
    public function testValidConstructorCreation()
    {
        $instance = new NumericEnumFixture(1);
        $this->assertTrue($instance instanceof NumericEnumFixture);
    }

    public function testValidStaticCreation()
    {
        $instance = NumericEnumFixture::LUKE();
        $this->assertTrue($instance instanceof NumericEnumFixture);
    }

    /**
     * @expectedException InvalidArgumentException
     */
    public function testInvalidConstructorThrowsException()
    {
        new NumericEnumFixture(4);
    }

    /**
     * @expectedException InvalidArgumentException
     */

    public function testInvalidStaticCreatorThrowsExceptoin()
    {
        NumericEnumFixture::LEIA();
    }

    public function testConstructorInstanceHasCorrectValue()
    {
        $instance = new NumericEnumFixture(1);
        $this->assertSame(1, $instance->value());
    }

    public function testConstructorInstanceHasCorrectKey()
    {
        $instance = new NumericEnumFixture(2);
        $this->assertSame('LUKE', $instance->key());
    }

    public function testConstructorInstanceHasCorrectString()
    {
        $instance = new NumericEnumFixture(3);
        $this->assertSame('Darth Vader', $instance->string());
    }

    public function testStaticInstanceHasCorrectValue()
    {
        $instance = NumericEnumFixture::HAN();
        $this->assertSame(1, $instance->value());
    }

    public function testStaticInstanceHasCorrectKey()
    {
        $instance = NumericEnumFixture::LUKE();
        $this->assertSame('LUKE', $instance->key());
    }

    public function testStaticInstanceHasCorrectString()
    {
        $instance = NumericEnumFixture::VADER();
        $this->assertSame('Darth Vader', $instance->string());
    }
}
