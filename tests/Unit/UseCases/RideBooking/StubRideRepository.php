<?php

namespace App\Tests\Unit\UseCases\RideBooking;

use App\RideBooking\Writes\BusinessLogic\Gateways\Repositories\RideRepository;
use App\RideBooking\Writes\BusinessLogic\Models\Ride;

class StubRideRepository implements RideRepository
{
    private array $rides = [];

    public function save(Ride $ride): void
    {
        $this->rides[] = $ride;
    }

    public function allRides(): array
    {
        return $this->rides;
    }
}
