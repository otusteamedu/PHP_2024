<?php

declare(strict_types=1);

namespace Core\Infrastructure\Factory;

use Core\Domain\Factory\UuidFactoryInterface;
use Core\Domain\ValueObject\Uuid;
use Ramsey\Uuid\Uuid as RamseyUuid;

final class UuidFactory implements UuidFactoryInterface
{
    public function next(): Uuid
    {
        return new Uuid(RamseyUuid::uuid4()->toString());
    }
}
