<?php

namespace App\Application\UseCase\ShowDirectory;

use App\Domain\ValueObject\Path;

readonly class ShowDirectoryRequest
{
    public function __construct(public Path $path)
    {
    }
}
