<?php

namespace App\RideBooking\Writes\BusinessLogic\Gateways\Repositories;

interface RidePriceRepository
{
    public function findBasePrice(string $tripDirection): float;

}
