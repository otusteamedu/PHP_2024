<?php

declare(strict_types=1);

namespace ERybkin\EmailValidator;

use ERybkin\EmailValidator\Validation\ValidationInterface;

interface ValidationPoolInterface
{
    /**
     * @return ValidationInterface[]
     */
    public function all(): array;
}