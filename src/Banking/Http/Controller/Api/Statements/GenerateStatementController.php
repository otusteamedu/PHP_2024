<?php

declare(strict_types=1);

namespace App\Banking\Http\Controller\Api\Statements;

use App\Banking\StatementGenerator\GenerateStatementData;
use App\Banking\StatementGenerator\StatementGeneratorInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

final readonly class GenerateStatementController
{
    public function __construct(
        private StatementGeneratorInterface $statementGenerator,
    ) {}

    public function __invoke(Request $request): JsonResponse
    {
        $payload = $request->getPayload();

        // TODO: validate payload

        $generateStatementData = new GenerateStatementData(
            userId: (int) $payload->get('user_id'),
            dateFrom: new \DateTimeImmutable($payload->get('date_from')),
            dateTo: new \DateTimeImmutable($payload->get('date_to')),
        );

        $data = [
            'success' => true,
            'message' => 'The statement was generated successfully'
        ];

        $statusCode = Response::HTTP_CREATED;

        try {
            $this->statementGenerator->generate($generateStatementData);
        } catch (\Exception $e) {
            $data['success'] = false;
            $data['message'] = $e->getMessage();

            $statusCode = Response::HTTP_BAD_REQUEST;
        } finally {
            return new JsonResponse($data, $statusCode);
        }
    }
}
