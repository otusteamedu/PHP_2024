<?php
declare(strict_types=1);

namespace IGalimov\Hw41\Http;

class Response
{
    /**
     * @param int $statusCode
     * @param string $message
     * @return string
     */
    static public function getResponse(int $statusCode, string $message): string
    {
        http_response_code($statusCode);
        return $message;
    }
}
