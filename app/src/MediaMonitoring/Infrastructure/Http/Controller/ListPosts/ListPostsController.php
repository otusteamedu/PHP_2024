<?php

declare(strict_types=1);

namespace App\MediaMonitoring\Infrastructure\Http\Controller\ListPosts;

use App\MediaMonitoring\Application\UseCase\ListPosts\ListPostsRequest;
use App\MediaMonitoring\Application\UseCase\ListPosts\ListPostsUseCase;
use App\MediaMonitoring\Application\UseCase\ListPosts\PostListItem;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Routing\Annotation\Route;

#[AsController]
#[Route('/api/v1/posts', methods: ['GET'])]
final readonly class ListPostsController
{
    public function __construct(
        private ListPostsUseCase $useCase,
    ) {}

    public function __invoke(): JsonResponse
    {
        $postListItems = $this->useCase->execute(new ListPostsRequest());

        $postListItems = array_map(
            static function (PostListItem $item): array {
                return [
                    'id' => $item->id->value(),
                    'title' => $item->title->value(),
                    'url' => $item->url->value(),
                    'date' => $item->date,
                ];
            },
            $postListItems->items
        );

        return new JsonResponse($postListItems);
    }
}
