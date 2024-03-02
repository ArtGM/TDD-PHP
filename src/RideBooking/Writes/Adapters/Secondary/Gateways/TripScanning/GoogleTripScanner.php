<?php

namespace App\RideBooking\Writes\Adapters\Secondary\Gateways\TripScanning;

use App\RideBooking\Writes\BusinessLogic\Gateways\TripScanning\TripScanner;
use Exception;
use yidas\googleMaps\Client;

class GoogleTripScanner implements TripScanner
{
    public function __construct(private readonly string $googleApiKey)
    {
    }

    /**
     * @throws Exception
     */
    function calculateDistance(string $departure, string $arrival): float
    {
        try {
            $googleMaps = new Client([
                'key' => $this->googleApiKey
            ]);
            $addresses = [
                'origin' => $departure,
                'destination' => $arrival
            ];
            $response = $googleMaps->distanceMatrix($addresses['origin'], $addresses['destination']);

            return $response['rows'][0]['elements'][0]['distance']['value'] / 1000;
        } catch (Exception $e) {
            dump($e->getMessage());
            throw new Exception($e->getMessage());
        }
    }
}
