<?php

namespace Jlem\Enum\Tests;

use Jlem\Enum\Tests\Fixtures\AutoStringFixture;
use Jlem\Enum\Tests\Fixtures\AutoString_GlobalFormatter_Fixture;
use Jlem\Enum\Tests\Fixtures\AutoString_CustomFormatter_Fixture;

class Method_AutoStrings extends \PHPUnit_Framework_TestCase
{
    public function testAutomaticallyFormatsConstantKeysToLowerCaseStrings()
    {
        $expected = [
            1 => 'han solo',
            2 => 'luke skywalker',
            3 => 'darth vader'
        ];

        // autoStrings is protected, but we've wired it up in `getStrings()`, so that is how we're testing this behavior
        $actual = AutoStringFixture::getStrings();

        $this->assertEquals($expected, $actual);
    }

    public function testAppliesGlobalFormatterFunctions()
    {
        $expected = [
            1 => 'han_solo',
            2 => 'luke_skywalker',
            3 => 'darth_vader'
        ];

        $actual = AutoString_GlobalFormatter_Fixture::getStrings();

        $this->assertEquals($expected, $actual);
    }

    public function testAppliesCustomFormatterFunctions()
    {
        $expected = [
            1 => 'Han Solo',
            2 => 'Luke Skywalker',
            3 => 'Darth Vader'
        ];

        $actual = AutoString_CustomFormatter_Fixture::getStrings();

        $this->assertEquals($expected, $actual);
    }
}