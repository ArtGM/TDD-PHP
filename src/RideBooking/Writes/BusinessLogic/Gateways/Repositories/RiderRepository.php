<?php

namespace App\RideBooking\Writes\BusinessLogic\Gateways\Repositories;

use Ramsey\Uuid\UuidInterface;

interface RiderRepository
{

    public function findById(UuidInterface $riderId);
}
