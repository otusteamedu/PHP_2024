<?php

namespace App\Controller\Http\News\Create\v1;

use App\Application\UseCase\News\CreateNews\CreateNewsUseCaseRequest;
use App\Application\UseCase\News\CreateNews\CreateNewsUseCaseResponse;
use App\Application\UseCase\News\GetTitle\GetTitleUseCaseRequest;
use App\Domain\Contract\Application\UseCase\CreateNewsUseCaseInterface;
use App\Domain\Contract\Application\UseCase\GetTitleUseCaseInterface;
use App\Domain\ValueObject\Url;

class ControllerManager
{
    public function __construct(
        private readonly GetTitleUseCaseInterface $getTitleUseCase,
        private readonly CreateNewsUseCaseInterface $createNewsUseCase,
    ) {
    }

    public function __invoke(CreateNewsControllerRequest $request): CreateNewsUseCaseResponse
    {
        return $this->createNews($request);
    }

    private function createNews($request): CreateNewsUseCaseResponse
    {
        $url = new Url($request->url);
        $getTitleUseCaseResponse = ($this->getTitleUseCase)(new GetTitleUseCaseRequest($url));

        return ($this->createNewsUseCase)(
            new CreateNewsUseCaseRequest(
                $getTitleUseCaseResponse->title,
                $getTitleUseCaseResponse->url
            )
        );
    }
}
