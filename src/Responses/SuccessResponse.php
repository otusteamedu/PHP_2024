<?php

declare(strict_types=1);

namespace App\Responses;

readonly class SuccessResponse implements ResponseInterface
{
    public function __construct(private string $message, private string $requestId)
    {
    }

    public function getStatusCode(): int
    {
        return 200;
    }

    public function toArray(): array
    {
        return [
            'status' => 'success',
            'message' => $this->message,
            'requestId' => $this->requestId,
        ];
    }

    public function toJson(): string
    {
        return json_encode($this->toArray(), JSON_UNESCAPED_UNICODE);
    }
}
