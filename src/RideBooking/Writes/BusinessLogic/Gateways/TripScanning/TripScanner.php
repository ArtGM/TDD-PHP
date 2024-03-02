<?php

namespace App\RideBooking\Writes\BusinessLogic\Gateways\TripScanning;

interface TripScanner
{
    public function calculateDistance(string $departure, string $arrival): float;
}
