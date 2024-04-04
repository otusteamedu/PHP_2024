<?php

declare(strict_types=1);

namespace Afilipov\Hw13;

use Attribute;

#[Attribute]
class DBField
{
    public function __construct(public string $fieldName)
    {
    }
}
