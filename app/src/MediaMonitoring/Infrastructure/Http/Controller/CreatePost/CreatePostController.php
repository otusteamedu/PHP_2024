<?php

declare(strict_types=1);

namespace App\MediaMonitoring\Infrastructure\Http\Controller\CreatePost;

use App\MediaMonitoring\Application\UseCase\CreatePost\CreatePostRequest;
use App\MediaMonitoring\Application\UseCase\CreatePost\CreatePostUseCase;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Annotation\Route;

#[AsController]
#[Route('/api/v1/posts', methods: ['POST'])]
final readonly class CreatePostController
{
    public function __construct(
        private CreatePostUseCase $createPostUseCase,
    ) {}

    public function __invoke(#[MapRequestPayload] CreatePostRequest $request): JsonResponse
    {
        $postId = $this->createPostUseCase->execute(
            new CreatePostRequest($request->url)
        )->postId;

        return new JsonResponse([
            'id' => $postId,
        ]);
    }
}
