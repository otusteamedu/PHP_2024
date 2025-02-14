<?php

declare(strict_types=1);

namespace App\Infrastructure\Http;

use App\Application\UseCase\GetStatementInRangeUseCase;
use App\Application\UseCase\GetStatementInRangeUseCaseRequest;
use App\Application\UseCase\GetStatementInRangeUseCaseResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Messenger\Bridge\Amqp\Transport\AmqpStamp;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\Attribute\Route;
use Throwable;

class GetBankStatementInRangeStatementController extends AbstractController
{
    public function __construct(
        private readonly GetStatementInRangeUseCase $useCase,
        private readonly MessageBusInterface        $messageBus
    )
    {
    }

    #[Route(path: '/statement/range', name: 'statement_range', methods: ['POST'])]
    public function __invoke(#[MapRequestPayload] GetStatementInRangeUseCaseRequest $request): JsonResponse
    {
        try {
            $event = ($this->useCase)($request);
            $this->messageBus->dispatch(
                $event,
                [
                    new AmqpStamp('notification.statement.created')
                ]
            );

            $response = new GetStatementInRangeUseCaseResponse('По готовности выписка будет отправлена на почту');

            return $this->json($response, 201);
        } catch (Throwable $exception) {
            $errorResponse = [
                'message' => $exception->getMessage(),
            ];
            return $this->json($errorResponse, 400);
        }
    }
}
