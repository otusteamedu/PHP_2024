<?php

declare(strict_types=1);

namespace App\Infrastructure\Service;

use App\Application\Service\UuidGeneratorInterface;
use Ramsey\Uuid\Uuid;

class UuidGenerator implements UuidGeneratorInterface
{
    public function generateUuid(): string
    {
        return Uuid::uuid4()->toString();
    }
}
