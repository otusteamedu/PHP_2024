<?php

declare(strict_types=1);

namespace App\Domain\Service;

interface INormalizer
{
    public function normalize(mixed $object, ?string $format = null, array $context = []): array;
}
