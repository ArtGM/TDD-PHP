<?php

namespace App\RideBooking\Writes\Adapters\Secondary\Gateways\Repositories\Doctrine\Entities;

use Doctrine\ORM\Mapping as ORM;
use Ramsey\Uuid\UuidInterface;

#[ORM\Entity]
#[ORM\Table(name: 'ride_prices')]
class RidePriceDoctrineEntity
{
    #[ORM\Id]
    #[ORM\Column(type: 'integer')]
    private int $id;

    #[ORM\Column(type: 'string')]
    private string $directionLabel;

    #[ORM\Column(type: 'float')]
    private float $price;

    public function __construct(int $id, string $directionLabel, float $price)
    {
        $this->id = $id;
        $this->directionLabel = $directionLabel;
        $this->price = $price;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getDirectionLabel(): string
    {
        return $this->directionLabel;
    }

    public function getPrice(): float
    {
        return $this->price;
    }


}

