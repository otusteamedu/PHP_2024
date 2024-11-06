<?php

declare(strict_types=1);

namespace App\MediaMonitoring\Application\UseCase\CreatePost;

use App\MediaMonitoring\Application\Exception\CouldNotParseWebsiteException;
use App\MediaMonitoring\Application\Service\WebsiteParserInterface;
use App\MediaMonitoring\Domain\Entity\Post;
use App\MediaMonitoring\Domain\Repository\PostRepositoryInterface;
use App\Shared\Domain\Exception\CouldNotSaveEntityException;
use DateTimeImmutable;

final readonly class CreatePostUseCase
{
    public function __construct(
        private PostRepositoryInterface $postRepository,
        private WebsiteParserInterface $websiteParser,
    ) {}

    /**
     * @throws CouldNotSaveEntityException
     */
    public function execute(CreatePostRequest $request): CreatePostResponse
    {
        try {
            $title = $this->websiteParser
                ->parse($request->url)
                ->getTitle()
            ;
        } catch (CouldNotParseWebsiteException $e) {
            throw CouldNotSaveEntityException::forEntity('Post', $e);
        }

        $post = Post::make(
            $title,
            new DateTimeImmutable(),
            $request->url,
        );

        $post = $this->postRepository->save($post);

        return new CreatePostResponse($post->id);
    }
}
