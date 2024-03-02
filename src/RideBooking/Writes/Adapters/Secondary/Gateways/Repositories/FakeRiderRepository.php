<?php

namespace App\RideBooking\Writes\Adapters\Secondary\Gateways\Repositories;

use App\RideBooking\Writes\BusinessLogic\Gateways\Repositories\RideRepository;
use App\RideBooking\Writes\BusinessLogic\Gateways\Repositories\RiderRepository;
use App\RideBooking\Writes\BusinessLogic\Models\Ride;
use App\RideBooking\Writes\BusinessLogic\Models\Rider;
use Ramsey\Uuid\UuidInterface;

class FakeRiderRepository implements RiderRepository
{
    private array $riders = [];

    public function findById(UuidInterface $riderId)
    {
        return $this->riders[$riderId->toString()];
    }

    public function setRiders(...$riders): void
    {
        foreach ($riders as $rider) {
            $this->riders[$rider->getId()->toString()] = $rider;
        }
    }

}
