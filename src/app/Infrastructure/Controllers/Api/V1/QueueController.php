<?php

declare(strict_types=1);

namespace App\Infrastructure\Controllers\Api\V1;

use App\Application\Requests\ReportRequest;
use App\Application\Services\QueueService;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

readonly class QueueController
{
    public function __construct(private QueueService $queueService)
    {
        //
    }

    public function addRequest(Request $request, Response $response): Response
    {
        $data = $request->getParsedBody()['data'] ?? '';

        $messageData = ReportRequest::fromJson($data);
        $this->queueService->sendMessage((string)$messageData);

        $response->getBody()->write('Запрос поставлен в очередь');
        $response->withHeader('Content-Type', 'application/json');

        return $response;
    }
}
