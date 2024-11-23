<?php

namespace SergeyShirykalov\OtusBracketsChecker;

class Response
{
    /**
     * Возвращает ответ
     *
     * @param string $message
     * @param int $code
     * @return string
     */
    public static function response(string $message = '', int $code = 200): string
    {
        http_response_code($code);
        return $message;
    }

}