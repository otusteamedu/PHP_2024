<?php

declare(strict_types=1);

namespace App\Infrastructure\Http\Controller;

use App\Application\UseCase\CreatePlaylistUseCase;
use App\Application\UseCase\Request\CreatePlaylistRequest;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/playlist/create', name: 'app_create_playlist', methods: ['POST'])]
class CreatePlaylistController extends AbstractController
{
    public function __invoke(
        #[MapRequestPayload] CreatePlaylistRequest $request,
        CreatePlaylistUseCase $createPlaylistUseCase,
    ): Response {
        $result = call_user_func_array($createPlaylistUseCase, [$request]);;

        return $this->json($result);
    }
}
