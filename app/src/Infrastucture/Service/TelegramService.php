<?php

declare(strict_types=1);

namespace Kagirova\Hw21\Infrastucture\Service;

use Curl\Curl;

class TelegramService
{
    public function sendMessage($text, $telegramChatId, $telegramToken)
    {
        $query = http_build_query([
            'chat_id' => $telegramChatId,
            'text' => "Новое сообщение!\nТекст: " . $text,
        ]);
        $url = "https://api.telegram.org/bot" . $telegramToken . "/sendMessage?" . $query;

        $curl = new Curl();
        $curl->get($url);
    }
}
