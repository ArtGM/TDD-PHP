<?php

namespace App\RideBooking\Writes\Adapters\Secondary\Gateways\TripScanning;

use App\RideBooking\Writes\BusinessLogic\Gateways\TripScanning\TripScanner;

class FakeTripScanner implements TripScanner
{
    private array $distancesByDirection = ['8 avenue Foch Paris-188 avenue Foch Paris' => 7,
        '111 avenue Victor Hugo Aubervilliers-8 avenue Foch Paris' => 30];

    public function calculateDistance(string $departure, string $arrival): float
    {
        return $this->distancesByDirection[$departure . '-' . $arrival];
    }
}
