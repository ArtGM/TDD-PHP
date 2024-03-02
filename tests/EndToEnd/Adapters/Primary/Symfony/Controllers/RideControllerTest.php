<?php

use App\RideBooking\Writes\BusinessLogic\Gateways\Repositories\RidePriceRepository;
use App\RideBooking\Writes\BusinessLogic\Gateways\UuidGeneration\UuidGenerator;
use App\RideBooking\Writes\BusinessLogic\Models\ClockUtils;
use App\RideBooking\Writes\BusinessLogic\Models\DeterministicClock;
use App\RideBooking\Writes\BusinessLogic\Models\RideSnapshot;
use Ramsey\Uuid\Rfc4122\UuidV4;

beforeEach(function() {
    $this->container->get(UuidGenerator::class)
        ->nextUuid = UuidV4::fromString('71efde49-0a02-4ede-9cd2-c8f773fd6baf');
    $clock = new DeterministicClock();
    $clock->dateNow = new \DateTimeImmutable("2022-11-25");
    ClockUtils::setClock($clock);
});

it('booking an UberX on Christmas with no birthday, total price should be doubled', function () {

    // GIVEN
    $this->container->get(RidePriceRepository::class);
    $this->entityManager->getConnection()->executeQuery(
        "INSERT INTO ride_prices (direction_label, price) 
VALUES ('LEAVING_PARIS', 60), ('ENTERING_PARIS', 20) "
    );

    // WHEN
    $this->client->request('POST',
        '/rides',
        [],
        [],
        ['CONTENT_TYPE' => 'application/json'],
        json_encode([
            'departure' => '8 avenue Foch Paris',
            'arrival' => '111 avenue Victor Hugo Aubervilliers',
            'isUberX' => true,
        ]));

    // THEN
    $this->assertResponseStatusCodeSame(201);

    assertJsonContent($this, 'Ride booked');

    $bookedRideSnapshots = selectAllRides($this->entityManager);

    expect($bookedRideSnapshots)->toEqual(
        [
            new RideSnapshot(
                UuidV4::fromString("71efde49-0a02-4ede-9cd2-c8f773fd6baf"),
                UuidV4::fromString("99efde49-0a02-4ede-9cd2-c8f773fd6bad"),
                '8 avenue Foch Paris',
                '111 avenue Victor Hugo Aubervilliers',
                9.687,
                true,
                69.8435,
                "LOOKING_FOR_DRIVER"
            )
        ]
    );

});

function assertJsonContent($self, string $message): void
{
    $response = $self->client->getResponse();
    $content = $response->getContent();

    $self->assertJson($content);

    $self->assertStringContainsString($message, $content);
}
