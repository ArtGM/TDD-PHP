<?php

/*
|--------------------------------------------------------------------------
| Test Case
|--------------------------------------------------------------------------
|
| The closure you provide to your test functions is always bound to a specific PHPUnit test
| case class. By default, that class is "PHPUnit\Framework\TestCase". Of course, you may
| need to change it using the "uses()" function to bind a different classes or traits.
|
*/

use App\RideBooking\Writes\Adapters\Secondary\Gateways\Repositories\Doctrine\Entities\RideDoctrineEntity;
use App\RideBooking\Writes\BusinessLogic\Models\RideSnapshot;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

uses()->group('unit')->in('Unit');

uses(KernelTestCase::class)->beforeEach(function () {
    $bootedKernel = $this::bootKernel(["environment" => "test"]);
    $this->container = $bootedKernel->getContainer();
    $this->entityManager = $this->container->get('doctrine')->getManager();
    cleanDatabase($this->entityManager);
})->group('integration')->in('Integration');

uses(WebTestCase::class)->beforeEach(function () {
    $this->client = $this::createClient(["environment", "test"]);
    $this->container = $this->client->getContainer();
    $this->entityManager = $this->container->get('doctrine')->getManager();
    cleanDatabase($this->entityManager);
})->group('e2e')->in('EndToEnd');

/*
|--------------------------------------------------------------------------
| Expectations
|--------------------------------------------------------------------------
|
| When you're writing tests, you often need to check that values meet certain conditions. The
| "expect()" function gives you access to a set of "expectations" methods that you can use
| to assert different things. Of course, you may extend the Expectation API at any time.
|
*/

expect()->extend('toBeOne', function () {
    return $this->toBe(1);
});

/*
|--------------------------------------------------------------------------
| Functions
|--------------------------------------------------------------------------
|
| While Pest is very powerful out-of-the-box, you may have some testing code specific to your
| project that you don't want to repeat in every file. Here you can also expose helpers as
| global functions to help you to reduce the number of lines of code in your test files.
|
*/
function cleanDatabase(EntityManagerInterface $entityManager): void
{
    $tables = ['rides'];
    $conn = $entityManager->getConnection();
    foreach ($tables as $table) {
        $sql = 'TRUNCATE TABLE ' . $table . ';';
        try {
            $stmt = $conn->prepare($sql);
            $stmt->executeStatement();
        } catch (\Exception $e) {
            dd($e);
        }
    }
}

function selectAllRides(EntityManagerInterface $entityManager): array {
    return array_map(
        function(RideDoctrineEntity $rideDoctrineEntity) {
            return new RideSnapshot(
                $rideDoctrineEntity->getId(),
                $rideDoctrineEntity->getRiderId(),
                $rideDoctrineEntity->getDeparture(),
                $rideDoctrineEntity->getArrival(),
                $rideDoctrineEntity->getDistance(),
                $rideDoctrineEntity->isUberX(),
                $rideDoctrineEntity->getPrice(),
                $rideDoctrineEntity->getStatus()
            );
        },
        $entityManager->getRepository(RideDoctrineEntity::class)->findAll());
}

