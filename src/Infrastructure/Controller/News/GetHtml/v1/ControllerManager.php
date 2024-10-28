<?php

namespace App\Infrastructure\Controller\News\GetHtml\v1;

use App\Application\UseCase\News\CreateHtml\CreateHtmlUseCaseResponse;
use App\Application\UseCase\News\GetNewsListByIdArray\GetNewsListByIdUseCaseRequest;
use App\Domain\Interface\UseCase\CreateHtmlUseCaseInterface;
use App\Domain\Interface\UseCase\GetNewsListByIdUseCaseInterface;

class ControllerManager
{
    public function __construct(
        private GetNewsListByIdUseCaseInterface $getNewsListByIdUseCase,
        private CreateHtmlUseCaseInterface $createHTMLUseCase
    ) {
    }

    public function __invoke(GetHtmlControllerRequest $request): CreateHtmlUseCaseResponse
    {
        return $this->getHtml($request);
    }

    private function getHtml(GetHtmlControllerRequest $request): CreateHtmlUseCaseResponse
    {
        $getNewsListByIdUseCaseRequest = new GetNewsListByIdUseCaseRequest($request->idArray);
        $getHtmlUseCaseRequest = ($this->getNewsListByIdUseCase)($getNewsListByIdUseCaseRequest);

        return ($this->createHTMLUseCase)($getHtmlUseCaseRequest);
    }
}
