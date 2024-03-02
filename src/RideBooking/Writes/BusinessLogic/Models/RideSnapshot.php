<?php

namespace App\RideBooking\Writes\BusinessLogic\Models;

use Ramsey\Uuid\UuidInterface;

class RideSnapshot
{
    public readonly UuidInterface $id;
    public readonly UuidInterface $riderId;
    public readonly string $departure;
    public readonly string $arrival;
    public readonly float $distance;
    public readonly bool $uberX;
    public readonly float $price;
    public readonly string $status;

    public function __construct(UuidInterface $id,
                                UuidInterface $riderId,
                                string        $departure,
                                string        $arrival,
                                float         $distance,
                                bool          $uberX,
                                float         $price,
                                string        $status)
    {
        $this->id = $id;
        $this->riderId = $riderId;
        $this->departure = $departure;
        $this->arrival = $arrival;
        $this->distance = $distance;
        $this->uberX = $uberX;
        $this->price = $price;
        $this->status = $status;
    }


}
