<?php

declare(strict_types=1);

namespace SFadeev\HW4;

enum ResponseStatus: int
{
    case HTTP_OK = 200;
    case HTTP_BAD_REQUEST = 400;
    case HTTP_INTERNAL_SERVER_ERROR = 500;

    /**
     * @return string
     */
    public function getText(): string
    {
        return match($this) {
            ResponseStatus::HTTP_OK => 'OK',
            ResponseStatus::HTTP_BAD_REQUEST => 'Bad Request',
            ResponseStatus::HTTP_INTERNAL_SERVER_ERROR => 'Internal Server Error',
        };
    }
}
