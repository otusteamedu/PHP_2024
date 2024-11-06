<?php

declare(strict_types=1);

namespace App\MediaMonitoring\Infrastructure\Http\Controller\ListPosts;

use App\MediaMonitoring\Domain\Entity\Post;
use App\MediaMonitoring\Domain\Repository\PostRepositoryInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Routing\Annotation\Route;

#[AsController]
#[Route('/api/v1/posts', methods: ['GET'])]
final readonly class ListPostsController
{
    public function __construct(
        private PostRepositoryInterface $postRepository,
    ) {}

    public function __invoke(): JsonResponse
    {
        $posts = array_map(
            static function (Post $post): array {
                return [
                    'id' => $post->id,
                    'title' => $post->title,
                    'date' => $post->date,
                    'url' => $post->url,
                ];
            },
            $this->postRepository->findAll()
        );

        return new JsonResponse($posts);
    }
}
