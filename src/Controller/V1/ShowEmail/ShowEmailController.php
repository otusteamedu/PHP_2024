<?php

declare(strict_types=1);

namespace App\Controller\V1\ShowEmail;

use App\UseCase\GetEmailById\GetEmailByIdUserCase;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Routing\Attribute\Route;

#[AsController]
final readonly class ShowEmailController
{
    public function __construct(
        private GetEmailByIdUserCase $getEmailByIdUserCase,
    ) {}

    #[Route(path: '/api/v1/emails/{emailId}', name: 'emails.show', methods: ['GET'])]
    public function __invoke(string $emailId): JsonResponse
    {
        $email = $this->getEmailByIdUserCase->execute($emailId);

        if ($email === null) {
            return new JsonResponse(['message' => 'Email not found'], Response::HTTP_NOT_FOUND);
        }

        return new JsonResponse($email->toArray());
    }
}
