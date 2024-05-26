<?php

declare(strict_types=1);

namespace App\Infrastructure\Http\Controller;

use App\Application\UseCase\AddNewsUseCase;
use App\Application\UseCase\Request\AddNewsRequest;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Attribute\Route;

#[Route(path: '/news/create', name: 'news_create', methods: 'POST')]
class AddNewsController extends  AbstractController
{
    public function __construct(
        private readonly AddNewsUseCase $addNewsUseCase,
    ) {
    }

    public function __invoke(
       #[MapRequestPayload] AddNewsRequest $request,
    ): Response {
        $result = $this->addNewsUseCase($request);

        return $this->json($result);
    }
}
