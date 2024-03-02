<?php

namespace App\RideBooking\Writes\Adapters\Secondary\Gateways\Repositories;

use App\RideBooking\Writes\BusinessLogic\Gateways\Repositories\RideRepository;
use App\RideBooking\Writes\BusinessLogic\Models\Ride;

class FakeRideRepository implements RideRepository
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
