<?php

declare(strict_types=1);

namespace App\Infrastructure\Http\Controller;

use App\Application\Request\CreateEventRequest;
use App\Application\UseCase\CreateEventUseCase;
use App\Domain\Exception\DomainException;
use App\Infrastructure\Http\Request\CreateEventHttpRequest;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Attribute\Route;

class CreateEventController extends AbstractController
{
    public function __construct(private readonly CreateEventUseCase $useCase)
    {
    }

    #[Route('/event', name: 'create_event', methods: ['POST'])]
    public function index(#[MapRequestPayload] CreateEventHttpRequest $request): Response
    {
        try {
            $createEventRequest = new CreateEventRequest(
                $request->event,
                $request->priority,
                $request->condition
            );
            ($this->useCase)($createEventRequest);
        } catch (DomainException $e) {
            return new Response($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
        return new Response();
    }
}
