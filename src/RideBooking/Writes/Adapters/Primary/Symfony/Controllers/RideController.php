<?php

namespace App\RideBooking\Writes\Adapters\Primary\Symfony\Controllers;

use App\RideBooking\Writes\BusinessLogic\Gateways\Repositories\RideRepository;
use App\RideBooking\Writes\BusinessLogic\UseCases\BookRideCommand;
use App\RideBooking\Writes\BusinessLogic\UseCases\BookRideCommandHandler;
use Ramsey\Uuid\Rfc4122\UuidV4;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/rides')]
class RideController extends AbstractController
{

    public function __construct(private readonly MessageBusInterface $messageBus)
    {
    }

    #[Route('', name: 'ride', methods: ['POST'])]
    public function bookARide(Request $request): JsonResponse
    {
        $postBody = json_decode($request->getContent(), true);
        $this->messageBus->dispatch(
            new BookRideCommand(
                UuidV4::fromString("99efde49-0a02-4ede-9cd2-c8f773fd6bad"),
                $postBody['departure'],
                $postBody['arrival'],
                $postBody['isUberX']
            )
        );
        return $this->json('Ride booked', 201);
    }
}
