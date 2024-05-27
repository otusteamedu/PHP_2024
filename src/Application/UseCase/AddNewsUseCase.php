<?php

declare(strict_types=1);

namespace App\Application\UseCase;

use App\Application\Exception\FailedToLoadHtmlContent;
use App\Application\Exception\PageTitleNotFoundException;
use App\Application\Service\GetPageTitleInterface;
use App\Application\UseCase\Request\AddNewsRequest;
use App\Application\UseCase\Response\AddNewsResponse;
use App\Application\UseCase\Response\DTO\AddedNewsDto;
use App\Domain\Entity\News;
use App\Domain\Repository\NewsRepositoryInterface;

class AddNewsUseCase
{

    public function __construct(
        private readonly NewsRepositoryInterface $newsRepository,
        private readonly GetPageTitleInterface $getPageTitle,
    ) {
    }

    public function __invoke(AddNewsRequest $request): AddNewsResponse
    {
        $url = $request->url;

        $html = file_get_contents($url);

        if ($html === false) {
            throw new FailedToLoadHtmlContent();
        }

        $title = $this->getPageTitle->getPageTitle($url);

        if (is_null($title)) {
            throw new PageTitleNotFoundException();
        }

        $news = News::createNew($title, $url);

        $this->newsRepository->addAndSaveNews($news);

        return new AddNewsResponse(new AddedNewsDto($news->getId()));
    }
}
