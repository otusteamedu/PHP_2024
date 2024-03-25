<?php

declare(strict_types=1);

namespace Afilipov\Hw12;

readonly class UserRequest
{
    public function __construct(public array $params)
    {
    }
}
