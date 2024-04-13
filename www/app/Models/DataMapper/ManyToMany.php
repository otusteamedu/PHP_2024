<?php

declare(strict_types=1);

namespace Hukimato\App\Models\DataMapper;

use Attribute;

#[Attribute]
class ManyToMany
{
    function __construct(
        public string $modelName,
        public string $relationName,
        public string $localKey,
        public string $foreignKey,
    )
    {
    }
}
