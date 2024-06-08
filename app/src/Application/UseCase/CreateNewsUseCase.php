<?php

declare(strict_types=1);

namespace App\Application\UseCase;

use App\Application\Dto\DomDto;
use App\Application\Service\DomParserInterface;
use App\Application\UseCase\Request\CreateNewsRequest;
use App\Application\UseCase\Response\CreateNewsResponse;
use App\Domain\Entity\News;
use App\Domain\Repository\NewsRepositoryInterface;
use App\Domain\ValueObject\Name;
use App\Domain\ValueObject\Url;
use Psr\Log\LoggerInterface;

class CreateNewsUseCase
{
    public function __construct(
        private readonly NewsRepositoryInterface $repository,
        private readonly DomParserInterface $parser,
        private readonly LoggerInterface $logger,
    ) {
    }

    /**
     * @throws \Exception
     */
    public function __invoke(CreateNewsRequest $request): CreateNewsResponse
    {
        try {
            $dto = $this->parser->parseTag(new DomDto($request->url, 'title'));
            $news = new News(
                new Url($request->url),
                new Name($dto->tagText),
            );
            $this->repository->save($news);

            return new CreateNewsResponse($news->getId());
        } catch (\Throwable $e) {
            $this->logger->error($e->getMessage(), ['exception' => $e]);
            throw new \Exception('Unable to create news.');
        }
    }
}
