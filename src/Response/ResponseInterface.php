<?php

declare(strict_types=1);

namespace App\Response;

interface ResponseInterface
{
    public function getContent(): string;

    public function getCode(): int;
}
