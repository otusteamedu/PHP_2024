<?php

declare(strict_types=1);

namespace App\Infrastructure\Http\Response;

use App\Infrastructure\Http\Traits\ResponseTrait;

class ErrorResponse
{
    use ResponseTrait;

    public function __construct(string $message)
    {
        $this->setSuccess(false);
        $this->setMessage($message);
    }
}
