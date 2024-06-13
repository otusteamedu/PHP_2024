<?php

declare(strict_types=1);

namespace Kagirova\Hw21\Infrastucture\Service;

use Curl\Curl;

class TelegramService
{
    const TELEGRAM_TOKEN = '5377759071:AAHaTUB2-mZ9KeDZCibmLgNSZ5MNEAeGhjc';
    const TELEGRAM_CHATID = '-4236494648';

    public function sendMessage($text)
    {
        $query = http_build_query([
            'chat_id' => TelegramService::TELEGRAM_CHATID,
            'text' => "Новое сообщение!\nТекст: " . $text,
        ]);
        $url = "https://api.telegram.org/bot" . TelegramService::TELEGRAM_TOKEN . "/sendMessage?" . $query;

        $curl = new Curl();
        $curl->get($url);
    }
}
