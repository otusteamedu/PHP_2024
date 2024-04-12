<?php

declare(strict_types=1);

namespace Alogachev\Homework\DataMapper\ORM;

use Attribute;

#[Attribute(Attribute::TARGET_CLASS)]
class Table
{
    public function __construct(
        public ?string $name = null
    ) {
    }
}
