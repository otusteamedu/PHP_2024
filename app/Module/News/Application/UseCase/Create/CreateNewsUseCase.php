<?php

declare(strict_types=1);

namespace Module\News\Application\UseCase\Create;

use Module\News\Application\Service\Interface\UrlParserServiceInterface;
use Module\News\Domain\Factory\NewsFactory;
use Module\News\Domain\Repository\NewsRepositoryInterface;

final readonly class CreateNewsUseCase
{
    public function __construct(
        private NewsRepositoryInterface $repository,
        private UrlParserServiceInterface $urlParserService,
        private NewsFactory $factory,
    ) {
    }

    public function __invoke(CreateRequest $request): CreateResponse
    {
        $title = $this->urlParserService->getTitle($request->url);
        $news = $this->factory->create($request->url, $title);
        $this->repository->create($news);

        return new CreateResponse($news->getId());
    }
}
