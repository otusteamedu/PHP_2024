<?php

declare(strict_types=1);

namespace App\Infrastructure\Http\Controller;

use App\Application\UseCase\GetNewsListUseCase;
use App\Application\UseCase\Request\GetNewsListRequest;
use App\Application\UseCase\Response\GetNewsListResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpKernel\Attribute\MapQueryString;
use Symfony\Component\Routing\Attribute\Route;

class GetNewsController extends AbstractController
{
    public function __construct(private readonly GetNewsListUseCase $useCase)
    {
    }

    #[Route('api/v1/news', name: 'get_news_create', methods: ['GET'])]
    public function __invoke(#[MapQueryString] GetNewsListRequest $request = new GetNewsListRequest()): GetNewsListResponse
    {
        return ($this->useCase)($request);
    }
}
