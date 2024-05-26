<?php

declare(strict_types=1);

namespace AlexanderGladkov\CleanArchitecture\Application\UseCase;

use AlexanderGladkov\CleanArchitecture\Application\Request\AddNewsRequest;
use AlexanderGladkov\CleanArchitecture\Application\Service\ParseUrl\ParseUrlServiceInterface;
use AlexanderGladkov\CleanArchitecture\Application\Service\ParseUrl\TitleNotFoundException;
use AlexanderGladkov\CleanArchitecture\Application\Service\ParseUrl\UrlNotFoundException;
use AlexanderGladkov\CleanArchitecture\Application\Exception\RequestValidationException;
use AlexanderGladkov\CleanArchitecture\Domain\Exception\DomainValidationException;
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
     * @throws RequestValidationException
     * @throws TitleNotFoundException
     * @throws UrlNotFoundException
     * @throws DomainValidationException
     */
    public function __invoke(AddNewsRequest $request): News
    {
        $this->validateRequestModel($request);
        $url = $request->getUrl();
        $title = $this->parseUrlService->parse($url);
        $title = mb_substr($title, 0, 255);
        return $this->addNews($url, $title);
    }

    /**
     * @throws DomainValidationException
     */
    private function addNews(string $url, string $title): News
    {
        $news = $this->newsRepository->findByUrl($url);
        if ($news === null) {
            $news = new News($url, $title);
        } else {
            $news->setTitle($title);
        }

        $this->validateDomainModel($news);
        $this->newsRepository->save($news);
        return $news;
    }
}
