<?php

declare(strict_types=1);

namespace Valen\App\Application\News\UseCase\AddNews;

use Valen\App\Application\News\UseCase\GetUrlInfo\GetUrlInfoUseCaseInterface;
use Valen\App\Domain\News\Factory\NewsFactoryInterface;
use Valen\App\Domain\News\Factory\UrlFactoryInterface;
use Valen\App\Domain\News\Repository\NewsRepositoryInterface;

class AddNewsUseCase
{
    public function __construct(
        private NewsRepositoryInterface $newsRepository,
        private NewsFactoryInterface $newsFactory,
        private UrlFactoryInterface $urlFactory,
        private GetUrlInfoUseCaseInterface $getUrlInfoUseCase,
    ) {
    }

    public function execute(AddNewsRequest $request): void
    {
        $url = $this->urlFactory->create($request->url);

        $title = $this->getUrlInfoUseCase->execute($url);
        $news = $this->newsFactory->create($url);

        // URL - это сущность?!
        // Создать URL
        // Получить Title
        // Создать Title
        // Создать новость
        // Сохранить новость
    }
}
