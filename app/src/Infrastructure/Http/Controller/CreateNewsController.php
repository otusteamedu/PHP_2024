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
    private CreateNewsUseCase $useCase;

    public function __construct(CreateNewsUseCase $useCase)
    {
        $this->useCase = $useCase;
    }

    #[Route('api/v1/news', name: 'news_create', methods: ['POST'])]
    public function __invoke(#[MapRequestPayload] CreateNewsRequest $request): CreateNewsResponse
    {
        return ($this->useCase)($request);
    }
}
