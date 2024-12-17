<?php

namespace App\Domain\Factory;

use App\Domain\Entity\Directory;

interface DirectoryFactoryInterface
{
    public function create(
        string $path,
        int $level
    ): Directory;

}