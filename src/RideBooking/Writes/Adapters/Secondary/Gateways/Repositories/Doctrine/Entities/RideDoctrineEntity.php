<?php

namespace App\RideBooking\Writes\Adapters\Secondary\Gateways\Repositories\Doctrine\Entities;

use Doctrine\ORM\Mapping as ORM;
use Ramsey\Uuid\UuidInterface;

#[ORM\Entity]
#[ORM\Table(name: 'rides')]
class RideDoctrineEntity
{
    #[ORM\Id]
    #[ORM\Column(type: 'uuid')]
    private UuidInterface $id;

    #[ORM\Column(type: 'uuid')]
    private UuidInterface $riderId;

    #[ORM\Column(type: 'string')]
    private string $departure;

    #[ORM\Column(type: 'string')]
    private string $arrival;

    #[ORM\Column(type: 'float')]
    private float $price;

    #[ORM\Column(type: 'float')]
    private float $distance;

    #[ORM\Column(type: 'boolean')]
    private float $uberX;

    #[ORM\Column(type: 'string')]
    private string $status;

    public function __construct(UuidInterface $id,
                                UuidInterface $riderId,
                                string $departure,
                                string $arrival,
                                float $distance,
                                float $price,
                                bool $uberX,
                                string $status)
    {
        $this->id = $id;
        $this->riderId = $riderId;
        $this->departure = $departure;
        $this->arrival = $arrival;
        $this->price = $price;
        $this->distance = $distance;
        $this->uberX = $uberX;
        $this->status = $status;
    }

    public function getId(): UuidInterface
    {
        return $this->id;
    }

    public function getRiderId(): UuidInterface
    {
        return $this->riderId;
    }

    public function getDeparture(): string
    {
        return $this->departure;
    }

    public function getArrival(): string
    {
        return $this->arrival;
    }

    public function getPrice(): float
    {
        return $this->price;
    }

    public function getDistance(): float
    {
        return $this->distance;
    }

    public function isUberX(): bool
    {
        return $this->uberX;
    }

    public function getStatus(): string
    {
        return $this->status;
    }




}

