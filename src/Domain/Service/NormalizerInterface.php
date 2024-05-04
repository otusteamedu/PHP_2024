<?php

declare(strict_types=1);

namespace App\Domain\Service;

interface NormalizerInterface
{
    public function normalize(mixed $object, ?string $format = null, array $context = []): array;
}
