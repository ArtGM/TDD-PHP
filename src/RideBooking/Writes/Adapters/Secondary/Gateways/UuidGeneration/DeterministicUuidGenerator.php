<?php

namespace App\RideBooking\Writes\Adapters\Secondary\Gateways\UuidGeneration;

use App\RideBooking\Writes\BusinessLogic\Gateways\UuidGeneration\UuidGenerator;
use Ramsey\Uuid\UuidInterface;

class DeterministicUuidGenerator implements UuidGenerator
{

    public UuidInterface $nextUuid;

    public function generate(): UuidInterface
    {
        return $this->nextUuid;
    }
}
