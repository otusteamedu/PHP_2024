<?php

namespace App\Infrastructure\Controller;

use App\Application\UseCase\AddNewsItemUseCase;
use App\Application\UseCase\Dto\SubmitNewsItemRequestDto;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/api')]
class AddNewsItemApiController extends AbstractController
{
    public function __construct(
        private readonly AddNewsItemUseCase $addNewsItemUseCase,
    ) {
    }

    #[Route('/news', methods: ['POST'])]
    public function indexAction(
        #[MapRequestPayload] SubmitNewsItemRequestDto $urlRequestDto,
    ): JsonResponse {
        $responseDto = ($this->addNewsItemUseCase)($urlRequestDto);

        return $this->json([
            'id' => $responseDto->id,
        ]);
    }
}
