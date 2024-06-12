<?php

declare(strict_types=1);

namespace App\Domain\Image;

enum Status: string
{
    case GENERATING = 'generating';
    case GENERATED = 'generated';
    case FAILED = 'failed';
}
