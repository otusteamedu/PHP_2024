<?php

declare(strict_types=1);

namespace App\Responses;

interface ResponseInterface
{
    public function getStatusCode(): int;

    public function toArray(): array;

    public function toJson(): string;
}
