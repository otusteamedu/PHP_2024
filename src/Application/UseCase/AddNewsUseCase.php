<?php

declare(strict_types=1);

namespace App\Application\UseCase;

use App\Application\Exception\FailedToLoadHtmlContent;
use App\Application\Exception\PageTitleNotFoundException;
use App\Application\UseCase\Request\AddNewsRequest;
use App\Application\UseCase\Response\AddNewsResponse;
use App\Domain\Entity\News;
use App\Domain\Interface\NewsRepositoryInterface;
use DOMDocument;

class AddNewsUseCase
{
    private DOMDocument $htmlParser;

    public function __construct(
        private readonly NewsRepositoryInterface $newsRepository,
    ) {
        $this->htmlParser = new DOMDocument();
    }

    public function __invoke(AddNewsRequest $request): AddNewsResponse
    {
        $url = $request->url;

        $html = file_get_contents($url);

        if ($html === false) {
            throw new FailedToLoadHtmlContent();
        }

        libxml_use_internal_errors(true);  // Подавление ошибок парсинга
        $this->htmlParser->loadHTML($html);
        libxml_clear_errors();  // Очистка ошибок после загрузки

        $titleTag = $this->htmlParser->getElementsByTagName('title')->item(0);

        if (is_null($titleTag)) {
            throw new PageTitleNotFoundException();
        }

        $news = News::createNew($titleTag->textContent, $url);

        $this->newsRepository->addAndSaveNews($news);

        return new AddNewsResponse($news->getId());
    }
}
