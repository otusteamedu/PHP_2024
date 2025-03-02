<?php

declare(strict_types=1);

namespace App\Application\Services;

use Predis\Client;

readonly class QueueService
{
    public function __construct(private Client $client)
    {
        //
    }

    public function addToQueue(string $data): string
    {
        $requestId = uniqid('req_', true);
        $this->client->set("request:$requestId", 'pending');
        $this->client->rpush('queue', (array)json_encode(['id' => $requestId, 'data' => $data]));
        return $requestId;
    }

    public function getStatus(string $requestId): ?string
    {
        return $this->client->get("request:$requestId") ?? null;
    }

    public function processQueue(): void
    {
        while ($item = $this->client->lpop('queue')) {
            $data = json_decode($item, true);
            $requestId = $data['id'];

            // Имитация обработки запроса
            sleep(3);

            $this->client->set("request:$requestId", 'processing');

            // Имитация обработки запроса
            sleep(5);

            $this->client->set("request:$requestId", 'completed');
        }
    }
}
