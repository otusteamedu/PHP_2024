<?php

declare(strict_types=1);

namespace Otus\Hw20\Infrastructure\Service;

use Symfony\Component\HttpClient\HttpClient;

class TelegramNotificationService
{
    public function __construct(
        private string $token,
        private string $chatId
    ) {}

    public function sendMessage(string $text): void
    {
        $client = HttpClient::create();
        $client->request('POST', "https://api.telegram.org/bot{$this->token}/sendMessage", [
            'json' => [
                'chat_id' => $this->chatId,
                'text' => $text
            ]
        ]);
    }
}
