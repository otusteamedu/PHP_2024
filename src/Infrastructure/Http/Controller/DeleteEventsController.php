<?php

declare(strict_types=1);

namespace App\Infrastructure\Http\Controller;

use App\Application\UseCase\DeleteEventsUseCase;
use App\Domain\Exception\DomainException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class DeleteEventsController extends AbstractController
{
    public function __construct(private readonly DeleteEventsUseCase $useCase)
    {
    }

    #[Route('/events', name: 'delete_events', methods: ['DELETE'])]
    public function index(): Response
    {
        try {
            ($this->useCase)();
        } catch (DomainException $e) {
            return new Response($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
        return new Response();
    }
}
