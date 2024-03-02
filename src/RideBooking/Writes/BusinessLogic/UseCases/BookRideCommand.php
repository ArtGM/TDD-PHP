<?php

namespace App\RideBooking\Writes\BusinessLogic\UseCases;

use Ramsey\Uuid\UuidInterface;

class BookRideCommand
{
    public function __construct(public UuidInterface $riderId, public string $departure, public string $arrival, public bool $isUberX)
    {
    }


}
