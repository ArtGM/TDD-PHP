<?php

namespace App\Tests\Unit\UseCases\RideBooking;

use App\RideBooking\Writes\BusinessLogic\Gateways\TripScanning\TripScanner;

class MockTripScanner implements TripScanner
{
    public float $distance = -1;
    public array $calculateDistanceWasCalledWith = [];

    public function calculateDistance(string $departure, string $arrival): float
    {
        $this->calculateDistanceWasCalledWith = [
            'departure' => $departure,
            'arrival' => $arrival
        ];
        return $this->distance;
    }

    /**
     * @throws \Exception
     */
    function verifyCalculateDistanceWasCalledWith(string $departure, string $arrival): void
    {
        if ($this->calculateDistanceWasCalledWith !== [
            'departure' => $departure,
            'arrival' => $arrival
        ]) {
            throw new \Exception("calculateDistance was not called with the expected arguments");
        }
    }

}
