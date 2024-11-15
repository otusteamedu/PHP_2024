<?php

declare(strict_types=1);

namespace App\MediaMonitoring\Application\UseCase\CreatePost;

use App\MediaMonitoring\Application\Exception\CouldNotParseWebsiteException;
use App\MediaMonitoring\Application\WebsiteParser\WebsiteParserInterface;
use App\MediaMonitoring\Domain\Entity\Post;
use App\MediaMonitoring\Domain\Entity\PostTitle;
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
                ->parse($request->url->value())
                ->getTitle()
            ;
        } catch (CouldNotParseWebsiteException $e) {
            throw CouldNotSaveEntityException::forEntity('Post', $e);
        }

        $post = new Post(
            id: null,
            title: new PostTitle($title),
            date: new DateTimeImmutable(),
            url: $request->url,
        );

        $post = $this->postRepository->save($post);

        return new CreatePostResponse($post->getId());
    }
}
