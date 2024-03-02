<?php

namespace App\RideBooking\Writes\BusinessLogic\Models;

use DateTimeImmutable;
use Psr\Clock\ClockInterface;

class SystemClock implements ClockInterface
{

    public function now(): DateTimeImmutable
    {
        return new DateTimeImmutable();
    }
}
