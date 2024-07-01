<?php

declare(strict_types=1);

namespace Alogachev\Homework\Infrastructure\Http\Response;

use Alogachev\Homework\Application\UseCase\Response\JsonResponseInterface;

readonly class ErrorResponse implements JsonResponseInterface
{
    public function __construct(
        public string $message,
    ) {
    }

    public function toArray(): array
    {
        return [
            'error' => $this->message,
        ];
    }
}
