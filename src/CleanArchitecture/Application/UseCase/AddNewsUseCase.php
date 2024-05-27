<?php

declare(strict_types=1);

namespace AlexanderGladkov\CleanArchitecture\Application\UseCase;

use AlexanderGladkov\CleanArchitecture\Application\UseCase\Request\AddNewsRequest;
use AlexanderGladkov\CleanArchitecture\Application\Service\ParseUrl\ParseUrlServiceInterface;
use AlexanderGladkov\CleanArchitecture\Application\Service\ParseUrl\TitleNotFoundException;
use AlexanderGladkov\CleanArchitecture\Application\Service\ParseUrl\UrlNotFoundException;
use AlexanderGladkov\CleanArchitecture\Domain\Exception\ValidationException;
use AlexanderGladkov\CleanArchitecture\Domain\Repository\NewsRepositoryInterface;
use AlexanderGladkov\CleanArchitecture\Domain\Service\ValidationServiceInterface;
use AlexanderGladkov\CleanArchitecture\Domain\Entity\News;

class AddNewsUseCase extends BaseUseCase
{
    public function __construct(
        ValidationServiceInterface $validationService,
        private ParseUrlServiceInterface $parseUrlService,
        private NewsRepositoryInterface $newsRepository
    ) {
        parent::__construct($validationService);
    }

    /**
     * @throws TitleNotFoundException
     * @throws UrlNotFoundException
     * @throws ValidationException
     */
    public function __invoke(AddNewsRequest $request): News
    {
        $this->validateModel($request);
        $url = $request->getUrl();
        $title = $this->parseUrlService->parse($url);
        $title = mb_substr($title, 0, 255);
        return $this->addNews($url, $title);
    }

    /**
     * @throws ValidationException
     */
    private function addNews(string $url, string $title): News
    {
        $news = $this->newsRepository->findByUrl($url);
        if ($news === null) {
            $news = new News($url, $title);
        } else {
            $news->editTitle($title);
        }

        $this->validateModel($news);
        $this->newsRepository->save($news);
        return $news;
    }
}
