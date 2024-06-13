<?php

declare(strict_types=1);

namespace AlexanderGladkov\CleanArchitecture\Application\UseCase\News;

use AlexanderGladkov\CleanArchitecture\Application\Service\ParseUrl\ParseUrlParams;
use AlexanderGladkov\CleanArchitecture\Application\Service\Validation\RequestValidationServiceInterface;
use AlexanderGladkov\CleanArchitecture\Application\UseCase\BaseUseCase;
use AlexanderGladkov\CleanArchitecture\Application\UseCase\Exception\RequestValidationException;
use AlexanderGladkov\CleanArchitecture\Application\UseCase\Request\News\AddNewsRequest;
use AlexanderGladkov\CleanArchitecture\Application\Service\ParseUrl\ParseUrlServiceInterface;
use AlexanderGladkov\CleanArchitecture\Application\Service\ParseUrl\TitleNotFoundException;
use AlexanderGladkov\CleanArchitecture\Application\Service\ParseUrl\UrlNotFoundException;
use AlexanderGladkov\CleanArchitecture\Application\UseCase\Response\News\AddNewsResponse;
use AlexanderGladkov\CleanArchitecture\Domain\Exception\ValidationException;
use AlexanderGladkov\CleanArchitecture\Domain\Repository\NewsRepositoryInterface;
use AlexanderGladkov\CleanArchitecture\Domain\Service\Validation\ValidationServiceInterface;
use AlexanderGladkov\CleanArchitecture\Domain\Entity\News;
use AlexanderGladkov\CleanArchitecture\Domain\ValueObject\NewsTitle;
use AlexanderGladkov\CleanArchitecture\Domain\ValueObject\Url;
use Psr\Log\LoggerInterface;

class AddNewsUseCase extends BaseUseCase
{
    public function __construct(
        private RequestValidationServiceInterface $requestValidationService,
        private ValidationServiceInterface $validationService,
        private ParseUrlServiceInterface $parseUrlService,
        private NewsRepositoryInterface $newsRepository
    ) {
        parent::__construct();
    }

    /**
     * @throws TitleNotFoundException
     * @throws UrlNotFoundException
     * @throws ValidationException
     * @throws RequestValidationException
     */
    public function __invoke(AddNewsRequest $request): AddNewsResponse
    {
        $this->checkRequestValidationErrors($this->requestValidationService->validateAddNewsRequestRequest($request));
        $url = $request->getUrl();
        $parseUrlResult = $this->parseUrlService->parse(new ParseUrlParams($url));
        $title = $parseUrlResult->getTitle();
        $title = mb_substr($title, 0, 255);
        $news = $this->addNews($url, $title);
        return new AddNewsResponse($news->getId());
    }

    /**
     * @throws ValidationException
     */
    private function addNews(string $url, string $title): News
    {
        $news = $this->newsRepository->findByUrl($url);
        if ($news === null) {
            $news = new News(new Url($url), new NewsTitle($title));
        } else {
            $news->changeTitle(new NewsTitle($title));
        }

        $this->checkValidationErrors($this->validationService->validateNews($news));
        $this->newsRepository->save($news);
        return $news;
    }
}
