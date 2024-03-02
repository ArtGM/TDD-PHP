<?php

namespace App\RideBooking\Writes\BusinessLogic\Models;

use Ramsey\Uuid\Rfc4122\UuidV4;
use Ramsey\Uuid\UuidInterface;

class Ride
{
    public function __construct(
        private readonly UuidInterface $id,
        private readonly UuidInterface $riderId,
        private readonly Trip          $trip,
        private readonly float         $price,
        private readonly string        $status)
    {
    }

    public static function book(UuidInterface $id,
                                Rider         $rider,
                                Trip          $trip,
                                float         $basePrice): Ride
    {
        return new self($id, $rider->getId(),
            $trip,
            self::calculatePrice($trip, $rider, $basePrice), 'LOOKING_FOR_DRIVER');
    }

    public static function restore(RideSnapshot $snapshot): Ride
    {
        return new self($snapshot->id, $snapshot->riderId,
            new Trip($snapshot->departure, $snapshot->arrival, $snapshot->distance,
                $snapshot->uberX), $snapshot->price, $snapshot->status);
    }

    public function takeSnapshot(): RideSnapshot
    {
        return new RideSnapshot($this->id,
            $this->riderId,
            $this->trip->getDeparture(),
            $this->trip->getArrival(),
            $this->trip->getDistance(),
            $this->trip->isUberX(),
            $this->price,
            $this->status);
    }

    private static function calculatePrice(Trip $trip, Rider $rider, float $basePrice): float
    {
        $classicPrice = self::determineMandatoryFees($trip, $basePrice) +
            self::determineExtraFees($trip, $rider);
        return self::countEventualExceptionalFees($classicPrice);
    }

    public static function determineMandatoryFees($trip, $basePrice): float
    {
        return $basePrice + $trip->getDistance() * 0.5;
    }

    private static function determineExtraFees($trip, Rider $rider): float
    {
        return $trip->isUberX() && !$rider->isBirthday() ? 5 : 0;
    }

    private static function countEventualExceptionalFees($classicPrice): float
    {
        return self::isChristmas() ? self::doubleThePrice($classicPrice) : $classicPrice;
    }

    public static function isChristmas(): bool
    {
        return (ClockUtils::now())->format('m-d') == '12-25';
    }

    public static function doubleThePrice($classicPrice): int|float
    {
        return $classicPrice * 2;
    }

    public function getId(): UuidInterface
    {
        return $this->id;
    }

    public function getRiderId(): UuidInterface
    {
        return $this->riderId;
    }

    public function getTrip(): Trip
    {
        return $this->trip;
    }

    public function getPrice(): float
    {
        return $this->price;
    }

    public function getStatus(): string
    {
        return $this->status;
    }

}
