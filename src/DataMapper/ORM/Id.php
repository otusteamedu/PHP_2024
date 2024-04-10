<?php

declare(strict_types=1);

namespace Alogachev\Homework\DataMapper\ORM;

use Attribute;

#[Attribute(Attribute::TARGET_PROPERTY)]
final class Id
{
    public function __construct(
        public string $strategy = IdAttributeDictionary::AUTO_INCREMENT_STRATEGY
    ) {
    }

    public function isAutoIncrementStrategy(): bool
    {
        return $this->strategy === IdAttributeDictionary::AUTO_INCREMENT_STRATEGY;
    }
}
