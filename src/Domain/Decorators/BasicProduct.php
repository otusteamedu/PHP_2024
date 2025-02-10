<?php

declare(strict_types=1);

namespace Domain\Decorators;

class BasicProduct implements ProductInterface
{
    public function __construct(protected string $description)
    {
        //
    }

    public function getDescription(): string
    {
        return $this->description;
    }
}
