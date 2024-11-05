<?php

declare(strict_types=1);

namespace Irayu\Hw13\Domain;

class User
{
    public function __construct(
        public readonly int $id,
        public readonly string $name,
        public readonly string $email,
    ) {
    }
}
