<?php

namespace App\Tests\Unit\UseCases\RideBooking;

use App\RideBooking\Writes\BusinessLogic\Gateways\Repositories\RidePriceRepository;

class StubRidePriceRepository implements RidePriceRepository
{
    public array $ridePrices = [];

    public function findBasePrice(string $tripDirection): float {
        return $this->ridePrices[$tripDirection];
    }

}
