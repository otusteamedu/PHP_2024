<?php

declare(strict_types=1);

namespace App\MediaMonitoring\Application\UseCase\ListPosts;

use App\MediaMonitoring\Domain\Entity\Post;
use App\MediaMonitoring\Domain\Repository\PostRepositoryInterface;

final readonly class ListPostsUseCase
{
    public function __construct(
        private PostRepositoryInterface $postRepository,
    ) {}

    public function execute(ListPostsRequest $request): ListPostsResponse
    {
        $posts = $this->postRepository->findAll();

        $postListItems = array_map(
            static fn(Post $post): PostListItem => new PostListItem(
                $post->getId(),
                $post->getTitle(),
                $post->getDate(),
                $post->getUrl(),
            ),
            $posts
        );

        return new ListPostsResponse(...$postListItems);
    }
}
