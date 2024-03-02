<?php

namespace App\RideBooking\Writes\Adapters\Secondary\Gateways\Repositories\Doctrine;

use App\RideBooking\Writes\Adapters\Secondary\Gateways\Repositories\Doctrine\Entities\RideDoctrineEntity;
use App\RideBooking\Writes\Adapters\Secondary\Gateways\Repositories\Doctrine\Entities\RidePriceDoctrineEntity;
use App\RideBooking\Writes\BusinessLogic\Gateways\Repositories\RidePriceRepository;
use App\RideBooking\Writes\BusinessLogic\Gateways\Repositories\RideRepository;
use App\RideBooking\Writes\BusinessLogic\Models\Ride;
use Doctrine\ORM\EntityManagerInterface;

class DoctrineRidePriceRepository implements RidePriceRepository
{

    public function __construct(private readonly EntityManagerInterface $entityManager)
    {
    }

    public function findBasePrice(string $tripDirection): float
    {
        return $this->entityManager->getRepository(RidePriceDoctrineEntity::class)->
        findOneBy(['directionLabel' => $tripDirection])->getPrice();
    }
}
