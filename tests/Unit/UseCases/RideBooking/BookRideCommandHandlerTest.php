<?php


use App\RideBooking\Writes\Adapters\Secondary\Gateways\UuidGeneration\DeterministicUuidGenerator;
use App\RideBooking\Writes\BusinessLogic\Models\ClockUtils;
use App\RideBooking\Writes\BusinessLogic\Models\DeterministicClock;
use App\RideBooking\Writes\BusinessLogic\Models\Ride;
use App\RideBooking\Writes\BusinessLogic\Models\Rider;
use App\RideBooking\Writes\BusinessLogic\Models\RideSnapshot;
use App\RideBooking\Writes\BusinessLogic\UseCases\BookRideCommand;
use App\RideBooking\Writes\BusinessLogic\UseCases\BookRideCommandHandler;
use App\Tests\Unit\UseCases\RideBooking\MockTripScanner;
use App\Tests\Unit\UseCases\RideBooking\StubRidePriceRepository;
use App\Tests\Unit\UseCases\RideBooking\StubRideRepository;
use App\Tests\Unit\UseCases\RideBooking\StubRiderRepository;
use Ramsey\Uuid\Rfc4122\UuidV4;

beforeEach(function () {
    $this->rideRepository = new StubRideRepository();
    $this->riderRepository = new StubRiderRepository();
    $this->ridePriceRepository = new StubRidePriceRepository();
    $this->tripScanner = new MockTripScanner();
    $this->clock = new DeterministicClock();
    $this->uuidGenerator = new DeterministicUuidGenerator();
    $this->rideId = UuidV4::fromString('4e3f5b1e-0b7a-4b0e-9b0a-9b9b9b9b9b9b');
    $this->uuidGenerator->nextUuid = $this->rideId;
    $this->riderId = UuidV4::fromString('3e3f5b1e-0b7a-4b0e-9b0a-9b9b9b9b9b9b');
    $this->tripScanner->distance = 1;
    $this->clock->dateNow = new DateTimeImmutable("2023-10-26");
    ClockUtils::setClock($this->clock);
    $this->riderRepository->setRiders(new Rider($this->riderId, new \DateTimeImmutable("1993-10-23")));
    $this->ridePriceRepository->ridePrices = [
        "WITHIN_PARIS" => 2,
        "LEAVING_PARIS" => 10,
        "ENTERING_PARIS" => 0,
        "OUTSIDE_PARIS" => 50,
    ];
});

it('can book a ride with mandatory fees like kilometers ones', function (
    string $departure,
    string $arrival,
    float  $distance,
    float  $expectedPrice
) {
    $this->tripScanner->distance = $distance;
    bookARide($this, $departure, $arrival);
    expectBookedRides($this,
        new RideSnapshot(
            $this->rideId,
            $this->riderId,
            $departure,
            $arrival,
            $distance,
            false,
            $expectedPrice,
            'LOOKING_FOR_DRIVER',
        )
    );
    try {
        $this->tripScanner->verifyCalculateDistanceWasCalledWith($departure, $arrival);
    } catch (Exception $e) {
        $this->fail($e->getMessage());
    }
})->with(
    [
        "short trip within Paris" => ["119 avenue Foch Paris", "8 avenue Foch Paris", 1, 2.5],
        "long trip within Paris" => ["119 avenue Foch Paris", "8 avenue Foch Paris", 20, 12],
        "short trip entering Paris" => ["119 avenue Foch Aubervilliers", "8 avenue Foch Paris", 1, 0.5],
        "short trip leaving Paris" => ["8 avenue Foch Paris", "119 avenue Foch Auber", 1, 10.5],
        "trip outside paris" => ["119 avenue Foch Aubervilliers", "8 avenue Foch Lorient", 20, 60],
    ]
);


it('should double price for a ride on christmas day', function () {
    $this->tripScanner->distance = 20;
    $this->clock->dateNow = new DateTimeImmutable("2023-12-25");
    bookARide($this, "119 avenue Foch Paris", "8 avenue Foch Paris");
    expectBookedRides($this,
        new RideSnapshot(
            $this->rideId,
            $this->riderId,
            "119 avenue Foch Paris",
            "8 avenue Foch Paris",
            20,
            false,
            24,
            'LOOKING_FOR_DRIVER',
        )
    );
});

it('should pay an extra fee of 5 euros when choosing uberX', function () {
    bookARide($this, "119 avenue Foch Paris", "8 avenue Foch Paris", true);
    expectBookedRides($this,
        new RideSnapshot(
            $this->rideId,
            $this->riderId,
            "119 avenue Foch Paris",
            "8 avenue Foch Paris",
            1,
            true,
            7.5,
            'LOOKING_FOR_DRIVER',
        )
    );
});

it("should offer the uberX for a ride booked on rider's birthday", function () {
    $this->clock->dateNow = new DateTimeImmutable("2023-10-23");
    bookARide($this, "119 avenue Foch Paris", "8 avenue Foch Paris", true);
    expectBookedRides($this,
        new RideSnapshot(
            $this->rideId,
            $this->riderId,
            "119 avenue Foch Paris",
            "8 avenue Foch Paris",
            1,
            true,
            2.5,
            'LOOKING_FOR_DRIVER',
        )
    );
});

function bookARide($self, string $departure, string $arrival, bool $isUberX = false): void
{
    (new BookRideCommandHandler(
        $self->rideRepository,
        $self->riderRepository,
        $self->ridePriceRepository,
        $self->tripScanner,
        $self->uuidGenerator))(
        new BookRideCommand(UuidV4::fromString("3e3f5b1e-0b7a-4b0e-9b0a-9b9b9b9b9b9b"),
            $departure,
            $arrival,
            $isUberX,
        )
    );
}

function expectBookedRides($self, ...$ridesSnapshots): void
{
    expect(array_map(function (Ride $ride) {
        return $ride->takeSnapshot();
    }, $self->rideRepository->allRides()))
        ->toEqual($ridesSnapshots);
}


