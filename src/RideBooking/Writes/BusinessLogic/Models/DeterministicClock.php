<?php

namespace App\RideBooking\Writes\BusinessLogic\Models;

use DateTimeImmutable;
use Psr\Clock\ClockInterface;

class DeterministicClock implements ClockInterface
{

    public \DateTimeImmutable $dateNow;

    /**
     * @throws \Exception
     */
    public function now(): DateTimeImmutable
    {
        return new DateTimeImmutable($this->dateNow->format('Y-m-d H:i:s'));
    }
}
