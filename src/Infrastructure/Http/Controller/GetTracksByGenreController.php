<?php

declare(strict_types=1);

namespace App\Infrastructure\Http\Controller;

use App\Application\UseCase\GetTracksByGenreUseCase;
use App\Application\UseCase\Request\GetTracksByGenreRequest;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\MapQueryString;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/tracks/genre', name: 'app_get_tracks_by_genre', methods: ['GET'])]
class GetTracksByGenreController extends AbstractController
{
    public function __invoke(
        GetTracksByGenreUseCase $tracksByGenreUseCase,
        #[MapQueryString] GetTracksByGenreRequest $request,
    ): Response {
        $result = call_user_func_array($tracksByGenreUseCase, [$request]);;

        return $this->json($result);
    }
}
