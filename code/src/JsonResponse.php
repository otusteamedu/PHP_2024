<?php

namespace SergeyShirykalov\YoutubeChannels;

class JsonResponse
{
    /**
     * Возвращает ответ
     *
     * @param array $message
     * @param int $code
     * @return string
     */
    public static function response(array $message = [], int $code = 200): string
    {
        http_response_code($code);
        header('Content-Type: application/json');
        return json_encode($message, JSON_UNESCAPED_UNICODE);
    }
}
