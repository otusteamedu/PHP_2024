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
class CreateTrack extends AbstractController
{
    public function __invoke(
        #[MapRequestPayload] CreateTrackRequest $request,
        CreateTrackUseCase $createTrackUseCase,
    ): Response {
        $result = call_user_func_array($createTrackUseCase, [$request]);;

        return $this->json([$result]);
    }
}
