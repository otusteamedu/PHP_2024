<?php

use App\Domain\ValueObject\Path;

class ShowDirectoryRequest
{
    public function __construct( public readonly Path $path)
    {
    }

}