<?php

namespace App\RideBooking\Writes\BusinessLogic\Models;

class Trip
{

    private string $departure;
    private string $arrival;

    private float $distance;

    private bool $uberX;

    public function __construct(string $departure, string $arrival, float $distance, bool $uberX)
    {
        $this->departure = $departure;
        $this->arrival = $arrival;
        $this->distance = $distance;
        $this->uberX = $uberX;
    }

    public function determineTripDirection(): string
    {
        $directions["PARIS_PARIS"] = 'WITHIN_PARIS';
        $directions["PARIS_OUTSIDE"] = 'LEAVING_PARIS';
        $directions["OUTSIDE_PARIS"] = 'ENTERING_PARIS';
        $directions["OUTSIDE_OUTSIDE"] = 'OUTSIDE_PARIS';
        $departurePosition = strPos($this->departure, "Paris") ? 'PARIS' : 'OUTSIDE';
        $arrivalPosition = strPos($this->arrival, "Paris") ? 'PARIS' : 'OUTSIDE';
        return $directions[$departurePosition . "_" . $arrivalPosition];
    }

    public function getDeparture(): string
    {
        return $this->departure;
    }

    public function getArrival(): string
    {
        return $this->arrival;
    }

    public function getDistance(): float
    {
        return $this->distance;
    }

    public function isUberX(): bool
    {
        return $this->uberX;
    }



}
