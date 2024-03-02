<?php

namespace App\RideBooking\Writes\BusinessLogic\Models;

use Ramsey\Uuid\UuidInterface;

class Rider
{
    public function __construct(private UuidInterface $id, private \DateTimeImmutable $birthdate)
    {
    }

    public function getId(): UuidInterface
    {
        return $this->id;
    }

    public function isBirthday()
    {
       return $this->birthdate->format('m-d') === (ClockUtils::now())->format('m-d');
    }

}
