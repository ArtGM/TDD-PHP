<?php

namespace App\RideBooking\Writes\BusinessLogic\Gateways\UuidGeneration;

use Ramsey\Uuid\UuidInterface;

interface UuidGenerator
{
    public function generate(): UuidInterface;
}
