<?php

declare(strict_types=1);

namespace App\Infrastructure\Web\Controller\Task;

use App\Application\UseCase\Exception\RequestValidationException;
use App\Application\UseCase\Request\Task\SendTaskRequest;
use App\Application\UseCase\Task\SendTaskUseCase;
use App\Domain\Exception\ValidationException;
use App\Infrastructure\Web\Factory\Response\JsonResponseFactory;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Annotation\Route;

class SendTaskController extends AbstractController
{
    public function __construct(
        private SendTaskUseCase $useCase,
        private JsonResponseFactory $jsonResponseFactory
    ) {
    }

    #[Route(
        '/task',
        methods: ['POST'],
        condition: 'request.getContentTypeFormat() === "json"',
    )]
    public function __invoke(
        #[MapRequestPayload(validationGroups: [''])] SendTaskRequest $sendTaskRequest
    ): JsonResponse {
        try {
            $sendTaskResponse = ($this->useCase)($sendTaskRequest);
        } catch (RequestValidationException $e) {
            return $this->jsonResponseFactory->createErrorsResponse($e->getErrors(), 400);
        } catch (ValidationException $e) {
            return $this->jsonResponseFactory->createErrorsResponse($e->getErrors(), 422);
        }

        return $this->jsonResponseFactory->createResponse(['id' => $sendTaskResponse->getId()]);
    }
}
