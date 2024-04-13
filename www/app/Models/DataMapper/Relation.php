<?php

declare(strict_types=1);

namespace Hukimato\App\Models\DataMapper;

use Attribute;

#[Attribute]
class Relation
{
    function __construct(
        public string $mapperClassName,
    )
    {
    }
}
