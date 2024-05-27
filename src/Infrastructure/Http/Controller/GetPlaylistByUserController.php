<?php

declare(strict_types=1);

namespace App\Infrastructure\Http\Controller;

use App\Application\UseCase\GetUserPlaylistsUseCase;
use App\Application\UseCase\Request\GetPlaylistsByUserRequest;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\MapQueryString;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/user/playlists', name: 'app_get_user_playlist', methods: ['GET'])]
class GetPlaylistByUserController extends AbstractController
{
    public function __construct(
        private readonly GetUserPlaylistsUseCase $getUserPlaylistsUseCase,
    ) {
    }

    public function __invoke(
        #[MapQueryString] GetPlaylistsByUserRequest $request,
    ): Response {
        $result = ($this->getUserPlaylistsUseCase)($request);

        return $this->json($result);
    }
}
