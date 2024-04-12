<?php

declare(strict_types=1);

namespace Alogachev\Homework\DataMapper\ORM;

use Attribute;

#[Attribute(Attribute::TARGET_PROPERTY)]
class Column
{
    public function __construct(
        public string $name,
        public string $type,
        public bool $nullable = false
    ) {
    }
}
