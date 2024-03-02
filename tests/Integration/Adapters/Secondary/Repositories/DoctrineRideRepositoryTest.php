<?php

use App\RideBooking\Writes\BusinessLogic\Gateways\Repositories\RideRepository;
use App\RideBooking\Writes\BusinessLogic\Models\Ride;
use App\RideBooking\Writes\BusinessLogic\Models\Trip;
use Doctrine\ORM\EntityManagerInterface;
use Ramsey\Uuid\Rfc4122\UuidV4;

it('can save a ride', function () {
    $rideRepository = $this->container->get(RideRepository::class);
    $ride = new Ride(
        UuidV4::fromString("71efde49-0a02-4ede-9cd2-c8f773fd6baf"),
        UuidV4::fromString("99efde49-0a02-4ede-9cd2-c8f773fd6bad"),
        new Trip("8 avenue Foch Paris",
        "12 avenue de Courcelles Paris",
        1, false),
        60,
        'LOOKING_FOR_DRIVER'
    );
    $rideRepository->save($ride);
    $savedRideSnapshots = selectAllRides($this->entityManager)[0];
    expect($savedRideSnapshots->id)->toEqual("71efde49-0a02-4ede-9cd2-c8f773fd6baf")
        ->and($savedRideSnapshots->riderId)->toEqual("99efde49-0a02-4ede-9cd2-c8f773fd6bad")
        ->and($savedRideSnapshots->departure)->toEqual("8 avenue Foch Paris")
        ->and($savedRideSnapshots->arrival)->toEqual("12 avenue de Courcelles Paris")
        ->and($savedRideSnapshots->distance)->toEqual(1)
        ->and($savedRideSnapshots->status)->toEqual("LOOKING_FOR_DRIVER")
        ->and($savedRideSnapshots->price)->toEqual("60");
});


