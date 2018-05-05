<?php namespace Jlem\Enum\Tests\Fixtures;

use Jlem\Enum\Enum;

final class AutoStringFixture extends Enum
{
    const HAN_SOLO = 1;
    const LUKE_SKYWALKER = 2;
    const DARTH_VADER = 3;

    public static function getStrings()
    {
        return static::autoStrings();
    }
}
