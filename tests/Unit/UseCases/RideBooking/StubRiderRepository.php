<?php

namespace App\Tests\Unit\UseCases\RideBooking;

use App\RideBooking\Writes\BusinessLogic\Gateways\Repositories\RiderRepository;
use Ramsey\Uuid\UuidInterface;

class StubRiderRepository implements RiderRepository
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
