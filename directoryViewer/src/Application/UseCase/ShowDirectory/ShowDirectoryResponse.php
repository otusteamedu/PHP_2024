<?php

namespace App\Application\UseCase\ShowDirectory;

readonly class ShowDirectoryResponse
{
    public function __construct(public string $directory)
    {
    }

}