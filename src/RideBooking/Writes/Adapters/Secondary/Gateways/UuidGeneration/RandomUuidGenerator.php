<?php

namespace App\RideBooking\Writes\Adapters\Secondary\Gateways\UuidGeneration;

use App\RideBooking\Writes\BusinessLogic\Gateways\UuidGeneration\UuidGenerator;
use Ramsey\Uuid\Rfc4122\UuidV4;
use Ramsey\Uuid\UuidInterface;

class RandomUuidGenerator implements UuidGenerator
{

    public function generate(): UuidInterface
    {
        return UuidV4::uuid4();
    }
}
