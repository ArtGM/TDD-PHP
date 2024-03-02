<?php

namespace App\RideBooking\Writes\BusinessLogic\Models;

use Psr\Clock\ClockInterface;

class ClockUtils
{

    private static ClockInterface $clock;

    public static function setClock(ClockInterface $clock): void
    {
        self::$clock = $clock;
    }

    public static function now(): \DateTimeImmutable
    {
        return self::getInstance()->now();
    }

    private static function getInstance(): ClockInterface
    {
        if(!isset(self::$clock)) {
            self::$clock = new SystemClock();
        }
        return self::$clock;
    }
}
