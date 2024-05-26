<?php

declare(strict_types=1);

namespace App\Infrastructure\Http\Controller;

use App\Application\UseCase\CreateNewsUseCase;
use App\Application\UseCase\Request\CreateNewsRequest;
use App\Application\UseCase\Response\CreateNewsResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Attribute\Route;

class CreateNewsController extends AbstractController
{
    public function __construct(
        private CreateNewsUseCase $useCase,
    ) {
    }

    /**
     * @throws \Exception
     */
    #[Route('api/v1/news', name: 'news_create', methods: ['POST'])]
    public function __invoke(#[MapRequestPayload] CreateNewsRequest $request): CreateNewsResponse
    {
        return ($this->useCase)($request);
    }
}
