<?php

declare(strict_types=1);

namespace App\Infrastructure\Web\Controller\Task;

use App\Application\UseCase\Exception\NotFoundException;
use App\Application\UseCase\Exception\RequestValidationException;
use App\Application\UseCase\Request\Task\GetTaskStatusRequest;
use App\Application\UseCase\Task\GetTaskStatusUseCase;
use App\Infrastructure\Web\Factory\Response\JsonResponseFactory;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class GetTaskStatusController extends AbstractController
{
    public function __construct(
        private GetTaskStatusUseCase $useCase,
        private JsonResponseFactory $jsonResponseFactory
    ) {
    }

    #[Route('task/{id}/status', methods: ['GET'])]
    public function __invoke(int $id): JsonResponse
    {
        try {
            $getTaskStatusResponse = ($this->useCase)(new GetTaskStatusRequest($id));
        } catch (NotFoundException) {
            return $this->jsonResponseFactory->createGeneralErrorResponse('Задача не найдена', 404);
        } catch (RequestValidationException $e) {
            return $this->jsonResponseFactory->createErrorsResponse($e->getErrors(), 400);
        }

        return $this->jsonResponseFactory->createResponse([
            'status' => $getTaskStatusResponse->getTaskStatus()->value
        ]);
    }
}
