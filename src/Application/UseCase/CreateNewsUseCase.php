<?php

declare(strict_types=1);

namespace App\Application\UseCase;

use App\Application\Gateway\ArticleParserInterface;
use App\Application\Gateway\Request\NewsRequest;
use App\Application\Helper\DTO\NewsPageDTO;
use App\Application\Helper\NewsTitleExtractorInterface;
use App\Application\UseCase\Request\CreateNewsRequest;
use App\Application\UseCase\Response\CreateNewsResponse;
use App\Application\Validator\CreateNewsValidatorInterface;
use App\Domain\Entity\News;
use App\Domain\Repository\NewsRepositoryInterface;
use App\Domain\ValueObject\Title;
use App\Domain\ValueObject\Url;

readonly class CreateNewsUseCase
{
    public function __construct(
        private ArticleParserInterface $client,
        private NewsRepositoryInterface $newsRepository,
        private NewsTitleExtractorInterface $newsTitleExtractor,
        private CreateNewsValidatorInterface $createNewsRequestValidator,
    ) {
    }

    public function __invoke(CreateNewsRequest $createNewsRequest): CreateNewsResponse
    {
        $this->createNewsRequestValidator->validate($createNewsRequest);

        $newsResponse = $this->client->parse(new NewsRequest($createNewsRequest->url));

        $newsTitleDTO = $this->newsTitleExtractor->extractTitle(new NewsPageDTO($newsResponse->html));
        $news = new News(new Url($createNewsRequest->url), new Title($newsTitleDTO->title), new \DateTime());

        $this->newsRepository->add($news);

        return new CreateNewsResponse($news->getId());
    }
}
