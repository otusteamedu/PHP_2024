<?php

declare(strict_types=1);

namespace App\Controller\V1\SendEmail;

use App\UseCase\CreateEmail\CreateEmailRequest;
use App\UseCase\CreateEmail\CreateEmailUseCase;
use Exception;
use OldSound\RabbitMqBundle\RabbitMq\ProducerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Attribute\Route;

#[AsController]
final readonly class SendEmailController
{
    public function __construct(
        private CreateEmailUseCase $createEmailUseCase,
        private ProducerInterface $producer,
    ) {}

    #[Route(path: '/api/v1/emails', name: 'emails.send', methods: ['POST'])]
    public function __invoke(#[MapRequestPayload] SendEmailRequest $request): JsonResponse
    {
        try {
            $email = $this->createEmailUseCase->execute(
                new CreateEmailRequest(
                    from: $request->from,
                    to: $request->to,
                    text: $request->text,
                )
            );
        } catch (Exception $e) {
            return new JsonResponse(['message' => $e->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        $this->producer->publish(json_encode(['email_id' => $email->id]));

        return new JsonResponse($email->toArray(), Response::HTTP_CREATED);
    }
}
