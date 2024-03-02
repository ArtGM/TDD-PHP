<?php

namespace App\RideBooking\Writes\BusinessLogic\UseCases;

use App\RideBooking\Writes\BusinessLogic\Gateways\Repositories\RidePriceRepository;
use App\RideBooking\Writes\BusinessLogic\Gateways\Repositories\RideRepository;
use App\RideBooking\Writes\BusinessLogic\Gateways\Repositories\RiderRepository;
use App\RideBooking\Writes\BusinessLogic\Gateways\TripScanning\TripScanner;
use App\RideBooking\Writes\BusinessLogic\Gateways\UuidGeneration\UuidGenerator;
use App\RideBooking\Writes\BusinessLogic\Models\Ride;
use App\RideBooking\Writes\BusinessLogic\Models\Trip;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
class BookRideCommandHandler
{

    public function __construct(
        private readonly RideRepository $rideRepository,
        private readonly RiderRepository $riderRepository,
        private readonly RidePriceRepository $ridePriceRepository,
        private readonly TripScanner $tripScanner,
        private readonly UuidGenerator $uuidGenerator,
    )
    {
    }

    public function __invoke(BookRideCommand $bookRideCommand): Ride
    {
        $rider = $this->riderRepository->findById($bookRideCommand->riderId);
        $distance = $this->tripScanner->calculateDistance($bookRideCommand->departure, $bookRideCommand->arrival);

        $trip = new Trip($bookRideCommand->departure, $bookRideCommand->arrival, $distance, $bookRideCommand->isUberX);

        $basePrice = $this->ridePriceRepository->findBasePrice($trip->determineTripDirection());
        $ride = Ride::book(
            $this->uuidGenerator->generate(),
            $rider,
            $trip,
            $basePrice
        );
        $this->rideRepository->save($ride);
        return $ride;
    }
}
