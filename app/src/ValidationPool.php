<?php

declare(strict_types=1);

namespace ERybkin\EmailValidator;

final readonly class ValidationPool implements ValidationPoolInterface
{
    public function __construct(
        private array $validations = []
    ) {}

    public function all(): array
    {
        return $this->validations;
    }
}
