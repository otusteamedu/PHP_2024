<?php

declare(strict_types=1);

namespace AlexanderGladkov\CleanArchitecture\Infrastructure\Constraint;

use Symfony\Component\Validator\Constraint;

#[\Attribute]
class PositiveIntegersArray extends Constraint
{
    public string $message = 'Should be array of positive integers';

    public function __construct(?string $message = null, ?array $groups = null, $payload = null)
    {
        parent::__construct([], $groups, $payload);
        $this->message = $message ?? $this->message;
    }
}
