<?php

declare(strict_types=1);

namespace App\Application\Query;

use App\Domain\ValueObject\Uuid;

class GetNewsQuery
{
    public function __construct(
        public Uuid $uuid
    ) {}

    public function getUuid(): Uuid
    {
        return $this->uuid;
    }
}
