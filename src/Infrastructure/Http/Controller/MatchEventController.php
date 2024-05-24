<?php

declare(strict_types=1);

namespace App\Infrastructure\Http\Controller;

use App\Application\UseCase\MatchEventUserCase;
use App\Domain\Exception\DomainException;
use App\Domain\Exception\NotFoundException;
use App\Infrastructure\Http\Request\MatchEventHttpRequest;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Attribute\Route;

class MatchEventController extends AbstractController
{
    public function __construct(private MatchEventUserCase $useCase)
    {
    }

    #[Route('/event/match', name: 'event_match', methods: ['POST'])]
    public function index(#[MapRequestPayload] MatchEventHttpRequest $request): Response
    {
        try {
            $event = ($this->useCase)($request->condition);
        } catch (NotFoundException $e) {
            return new Response($e->getMessage(), Response::HTTP_NOT_FOUND);
        } catch (DomainException $e) {
            return new Response($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
        return new JsonResponse(
            [
                'event' => $event->event,
                'priority' => $event->priority,
                'condition' => $event->condition
            ]
        );
    }
}
