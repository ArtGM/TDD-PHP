<?php

namespace App\RideBooking\Writes\BusinessLogic\Gateways\Repositories;

use App\RideBooking\Writes\BusinessLogic\Models\Ride;

interface RideRepository
{
    public function save(Ride $ride): void;

}
