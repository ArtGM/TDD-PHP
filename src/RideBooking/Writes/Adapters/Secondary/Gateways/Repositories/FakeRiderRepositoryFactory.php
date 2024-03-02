<?php

namespace App\RideBooking\Writes\Adapters\Secondary\Gateways\Repositories;

use App\RideBooking\Writes\BusinessLogic\Models\Rider;
use Ramsey\Uuid\Rfc4122\UuidV4;

class FakeRiderRepositoryFactory
{
    public static function create(): FakeRiderRepository
    {
        $riderRepository = new FakeRiderRepository();
        $riderRepository->setRiders(new Rider(UuidV4::fromString("99efde49-0a02-4ede-9cd2-c8f773fd6bad"),
            new \DateTimeImmutable("2024-02-22")));
        return $riderRepository;
    }
}
