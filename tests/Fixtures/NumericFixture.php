<?php namespace Jlem\Enum\Tests\Fixtures;

use Jlem\Enum\Enum;

final class NumericFixture extends Enum
{
    const HAN = 1;
    const LUKE = 2;
    const VADER = 3;

    public static function getStrings()
    {
        return array(
            self::HAN => 'Han Solo',
            self::LUKE => 'Luke Skywalker',
            self::VADER => 'Darth Vader'
        );
    }
}
