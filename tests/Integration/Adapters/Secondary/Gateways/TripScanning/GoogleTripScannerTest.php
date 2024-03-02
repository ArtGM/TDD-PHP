<?php


use App\RideBooking\Writes\BusinessLogic\Gateways\TripScanning\TripScanner;

it('should calculate the distance between two addresses', function () {
    $googleTripScanner = $this->container->get(TripScanner::class);
    expect($googleTripScanner->calculateDistance(
        "12 rue de Courcelles Paris",
        "20 rue Taylor Paris"
    ))->toBeLessThan(4.94)->toBeGreaterThan(4.91);
});
