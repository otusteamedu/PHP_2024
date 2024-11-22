<?php

namespace App\Controller\Http\News\GetHtml\v1;

use App\Application\UseCase\News\CreateHtml\CreateHtmlUseCaseResponse;
use App\Application\UseCase\News\GetNewsListByIdArray\GetNewsListByIdUseCaseRequest;
use App\Domain\Contract\Application\UseCase\CreateHtmlUseCaseInterface;
use App\Domain\Contract\Application\UseCase\GetNewsListByIdUseCaseInterface;

class ControllerManager
{
    public function __construct(
        private readonly GetNewsListByIdUseCaseInterface $getNewsListByIdUseCase,
        private readonly CreateHtmlUseCaseInterface $createHTMLUseCase
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
