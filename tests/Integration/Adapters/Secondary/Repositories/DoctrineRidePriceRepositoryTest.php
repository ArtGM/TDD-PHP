<?php

use App\RideBooking\Writes\BusinessLogic\Gateways\Repositories\RidePriceRepository;

it('can find a ride price', function () {
    // GIVEN
    $ridePriceRepository = $this->container->get(RidePriceRepository::class);
    $this->entityManager->getConnection()->executeQuery(
        "INSERT INTO ride_prices (direction_label, price) 
VALUES ('LEAVING_PARIS', 60), ('ENTERING_PARIS', 20) "
    );

    // WHEN
    $ridePrice = $ridePriceRepository->findBasePrice('LEAVING_PARIS');

    // THEN
    expect($ridePrice)->toEqual("60");
});
