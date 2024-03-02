<?php

namespace App\RideBooking\Writes\Adapters\Secondary\Gateways\Repositories;

use App\RideBooking\Writes\BusinessLogic\Gateways\Repositories\RidePriceRepository;

class FakeRidePriceRepository implements RidePriceRepository
{
    private array $ridePrices = [];

    public function findBasePrice(string $tripDirection): float
    {
        return $this->ridePrices[$tripDirection];
    }
}
