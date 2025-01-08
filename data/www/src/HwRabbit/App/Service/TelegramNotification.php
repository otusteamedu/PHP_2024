<?php

namespace VladimirGrinko\Rabbit\App\Service;

class TelegramNotification implements NotificationInterface
{
    private string $botToken;

    public function __construct(string $botToken)
    {
        $this->botToken = $botToken;
    }

    public function send(string $to, string $subject, string $message): void
    {
        $text = "*{$subject}*\n\n{$message}";
        $url = "https://api.telegram.org/bot{$this->botToken}/sendMessage";

        $data = [
            'chat_id' => $to,
            'text' => $text,
            'parse_mode' => 'Markdown',
        ];

        $response = file_get_contents($url . '?' . http_build_query($data));

        if (!$response) {
            throw new \Exception("Ошибка при отправке сообщения в Telegram");
        }
    }
}
