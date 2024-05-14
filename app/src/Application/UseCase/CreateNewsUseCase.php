<?php

declare(strict_types=1);

namespace App\Application\UseCase;

use App\Application\Service\DomParserInterface;
use App\Application\UseCase\Request\CreateNewsRequest;
use App\Application\UseCase\Response\CreateNewsResponse;
use App\Domain\Entity\News;
use App\Domain\Repository\NewsRepositoryInterface;
use App\Domain\ValueObject\Name;
use App\Domain\ValueObject\Url;

readonly class CreateNewsUseCase
{
    public function __construct(
        private NewsRepositoryInterface $repository,
        private DomParserInterface $parser,
    ) {
    }

    public function __invoke(CreateNewsRequest $request): CreateNewsResponse
    {
        $title = $this->parser->parseTag($request->url, 'title');
        $news = new News(
            new Url($request->url),
            new Name($title),
        );
        $this->repository->save($news);

        return new CreateNewsResponse($news->getId());
    }
}
