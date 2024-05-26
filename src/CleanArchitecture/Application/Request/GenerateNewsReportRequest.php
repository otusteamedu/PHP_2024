<?php

declare(strict_types=1);

namespace AlexanderGladkov\CleanArchitecture\Application\Request;

use Symfony\Component\Validator\Constraints as Assert;
use AlexanderGladkov\CleanArchitecture\Infrastructure\Constraint as CustomAssert;

class GenerateNewsReportRequest
{
    #[Assert\NotNull]
    #[Assert\Type('array')]
    #[CustomAssert\PositiveIntegersArray]
    readonly private mixed $ids;

    public function __construct(mixed $ids)
    {
        $this->ids = $ids;
    }

    public function getIds(): array
    {
        return (array)$this->ids;
    }
}