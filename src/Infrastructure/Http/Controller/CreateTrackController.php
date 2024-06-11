<?php

declare(strict_types=1);

namespace App\Infrastructure\Http\Controller;

use App\Application\UseCase\CreateTrackUseCase;
use App\Application\UseCase\Request\CreateTrackRequest;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/track/create', name: 'app_create_track', methods: ['POST'])]
class CreateTrackController extends AbstractController
{
    public function __construct(
        private readonly CreateTrackUseCase $createTrackUseCase,
    ) {
    }

    public function __invoke(
        #[MapRequestPayload] CreateTrackRequest $request,
    ): Response {
        $result = ($this->createTrackUseCase)($request);

        return $this->json($result);
    }
}
