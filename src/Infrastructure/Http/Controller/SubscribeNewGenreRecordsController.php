<?php

declare(strict_types=1);

namespace App\Infrastructure\Http\Controller;

use App\Application\UseCase\Request\SubscribeNewGenreRecordsRequest;
use App\Application\UseCase\SubscribeNewGenreRecordsUseCase;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/genre/subscribe', name: 'app_subscribe_to_new_tracks_by_genre', methods: ['POST'])]
class SubscribeNewGenreRecordsController extends AbstractController
{
    public function __construct(
        private readonly SubscribeNewGenreRecordsUseCase $subscribeUseCase,
    ) {
    }

    public function __invoke(
        #[MapRequestPayload] SubscribeNewGenreRecordsRequest $request
    ): Response {
        $result = ($this->subscribeUseCase)($request);

        return $this->json($result);
    }
}
