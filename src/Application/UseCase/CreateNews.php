<?php

declare(strict_types=1);

namespace App\Application\UseCase;

use App\Domain\Repository\NewsInterface;
use App\Domain\Entity\News;
use App\Application\UseCase\Request\CreateNewsRequest;
use App\Application\UseCase\Response\CreateNewsResponse;
use App\Domain\ValueObject\Url;
use App\Domain\ValueObject\Title;

class CreateNews
{
    public function __construct(private NewsInterface $newsRepository) {}

    public function __invoke(CreateNewsRequest $request): CreateNewsResponse
    {
        $dom = new \DOMDocument();
        $internalErrors = libxml_use_internal_errors(true);

        if (!$dom->loadHTMLFile($request->url)) {
            throw new \Exception("Не удалось загрузить новость");
        }

        libxml_use_internal_errors($internalErrors);

        $list = $dom->getElementsByTagName("title");

        if ($list->length <= 0) {
            throw new \Exception("Не удалось получить заголовок новости");
        }

        $title = $list->item(0)->textContent;

        $news = new News(
            new Url($request->url),
            new Title($title)
        );

        $this->newsRepository->save($news);

        return new CreateNewsResponse($news->getId());
    }
}
