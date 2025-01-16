<?php

declare(strict_types=1);

namespace App\Banking\Http\Controller\Api\Statements;

use App\Banking\Queue\PublisherInterface;
use Exception;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

final readonly class GenerateStatementAsyncController
{
    public function __construct(
        private PublisherInterface $publisher,
    ) {}

    public function __invoke(Request $request): JsonResponse
    {
        $payload = $request->getPayload();

        // TODO: validate payload

        $payload = [
            'user_id' => $payload->get('user_id'),
            'date_from' => $payload->get('date_from'),
            'date_to' => $payload->get('date_to'),
        ];

        $data = [
            'success' => true,
            'message' => 'The statement generation was successfully scheduled'
        ];

        $statusCode = Response::HTTP_ACCEPTED;

        try {
            $this->publisher->publish(json_encode($payload, JSON_THROW_ON_ERROR));
        } catch (Exception $e) {
            $data['success'] = false;
            $data['message'] = $e->getMessage();

            $statusCode = Response::HTTP_BAD_REQUEST;
        } finally {
            return new JsonResponse($data, $statusCode);
        }
    }
}
