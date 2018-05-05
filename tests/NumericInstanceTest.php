<?php namespace Jlem\Enum\Tests;

use Jlem\Enum\Tests\Fixtures\NumericFixture;


/**
 * This tests all instance methods of a given enumeration instance
 */

class NumericInstanceTest extends \PHPUnit_Framework_TestCase
{
    public function testValidConstructorCreation()
    {
        $instance = new NumericFixture(1);
        $this->assertTrue($instance instanceof NumericFixture);
    }

    public function testValidStaticCreation()
    {
        $instance = NumericFixture::LUKE();
        $this->assertTrue($instance instanceof NumericFixture);
    }

    /**
     * @expectedException InvalidArgumentException
     */
    public function testInvalidConstructorThrowsException()
    {
        new NumericFixture(4);
    }

    /**
     * @expectedException InvalidArgumentException
     */

    public function testInvalidStaticCreatorThrowsException()
    {
        NumericFixture::LEIA();
    }


    /**
     * @expectedException InvalidArgumentException
     * @expectedExceptionMessage Expected a numeric value
     */

    public function testInvalidStringArgumentThrowsExceptionWithRightMessage()
    {
        new NumericFixture("3");
    }


    public function testValueConversion()
    {
        $instance = new NumericFixture(1);
        $this->assertSame(1, $instance->value());
    }

    public function testKeyConversion()
    {
        $instance = new NumericFixture(2);
        $this->assertSame('LUKE', $instance->key());
    }

    public function testExplicitStringConversion()
    {
        $instance = new NumericFixture(3);
        $this->assertSame('Darth Vader', $instance->string());
    }

    public function testImplicitStringConversion()
    {
        $instance = new NumericFixture(1);
        $this->assertSame('Han Solo', (string)$instance);
    }

    public function testStringFormatting()
    {
        $instance = new NumericFixture(1);
        $this->assertSame('han solo', $instance->string('strtolower'));
    }
}
