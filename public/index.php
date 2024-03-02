<?php

use App\Kernel;
use App\RideBooking\Writes\BusinessLogic\Models\ClockUtils;
use App\RideBooking\Writes\BusinessLogic\Models\DeterministicClock;

require_once dirname(__DIR__).'/vendor/autoload_runtime.php';

return function (array $context) {
    $clock = new DeterministicClock();
    $clock->dateNow = new \DateTimeImmutable("2022-11-25");
    ClockUtils::setClock($clock);
    return new Kernel($context['APP_ENV'], (bool) $context['APP_DEBUG']);
};
