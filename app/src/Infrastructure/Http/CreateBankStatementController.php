<?php

declare(strict_types=1);

namespace App\Infrastructure\Http;

use App\Application\UseCase\GetBankStatementUseCase;
use App\Application\UseCase\SubmitStatementRequest;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;

class CreateBankStatementController extends AbstractFOSRestController
{
    public function __construct(private GetBankStatementUseCase $useCase)
    {
    }

    #[Route('/api/v1/statement', name: 'create_statement', methods: ['POST'])]
    public function __invoke(#[MapRequestPayload] SubmitStatementRequest $request): Response
    {
        try {
            $response = ($this->useCase)($request);
            return new Response(
                json_encode(
                    [
                    'id' => $response->id
                    ]
                ),
                201
            );
        } catch (\Throwable $e) {
            $errorResponse = [
                'message' => $e->getMessage()
            ];
            return new Response(json_encode($errorResponse), 400);
        }
    }
}
