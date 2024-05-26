<?php

declare(strict_types=1);

namespace App\Domain\Service;

interface NormalizerInterface
{
    // УБрать на апликатио
    public function normalize(mixed $object, ?string $format = null, array $context = []): array;
}
