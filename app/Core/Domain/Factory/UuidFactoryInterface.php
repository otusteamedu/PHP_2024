<?php

declare(strict_types=1);

namespace Core\Domain\Factory;

use Core\Domain\ValueObject\Uuid;

interface UuidFactoryInterface
{
    public function next(): Uuid;
}
