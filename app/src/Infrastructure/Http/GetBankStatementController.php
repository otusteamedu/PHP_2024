<?php

declare(strict_types=1);

namespace App\Infrastructure\Http;

use FOS\RestBundle\Controller\AbstractFOSRestController;
use Symfony\Component\HttpFoundation\Response;
use App\Application\UseCase\GetStatusBankStatementUseCase;
use Symfony\Component\Routing\Attribute\Route;
use App\Application\UseCase\GetStatusStatementRequest;

class GetBankStatementController extends AbstractFOSRestController
{
    public function __construct(private GetStatusBankStatementUseCase $useCase)
    {
    }

    #[Route('/api/v1/statement/{id}', name: 'get_statement', methods: ['GET'])]
    public function __invoke(int $id): Response
    {
        try {
            $response = ($this->useCase)(new GetStatusStatementRequest($id));
            $responseData = $response->data;
            return new Response(
                json_encode($responseData),
                200
            );
        } catch (\Throwable $e) {
            $errorResponse = [
                'message' => $e->getMessage()
            ];
            return new Response(json_encode($errorResponse), 400);
        }
    }
}
