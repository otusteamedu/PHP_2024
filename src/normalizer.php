<?php

declare(strict_types=1);

namespace Normalizer;

function normalize(string $string): string
{
    return  preg_replace('/\s+/', '', $string);
}
