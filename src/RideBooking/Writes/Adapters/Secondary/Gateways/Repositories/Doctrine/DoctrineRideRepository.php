<?php

namespace App\RideBooking\Writes\Adapters\Secondary\Gateways\Repositories\Doctrine;

use App\RideBooking\Writes\Adapters\Secondary\Gateways\Repositories\Doctrine\Entities\RideDoctrineEntity;
use App\RideBooking\Writes\BusinessLogic\Gateways\Repositories\RideRepository;
use App\RideBooking\Writes\BusinessLogic\Models\Ride;
use Doctrine\ORM\EntityManagerInterface;

class DoctrineRideRepository implements RideRepository
{

    public function __construct(private readonly EntityManagerInterface $entityManager)
    {
    }

    public function save(Ride $ride): void
    {
        $rideSnapshot = $ride->takeSnapshot();
        $rideDoctrineEntity = new RideDoctrineEntity(
            $rideSnapshot->id,
            $rideSnapshot->riderId,
            $rideSnapshot->departure,
            $rideSnapshot->arrival,
            $rideSnapshot->distance,
            $rideSnapshot->price,
            $rideSnapshot->uberX,
            $rideSnapshot->status
        );
        $this->entityManager->persist($rideDoctrineEntity);
        $this->entityManager->flush();
    }
}
