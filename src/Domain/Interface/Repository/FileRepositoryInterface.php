<?php

namespace App\Domain\Interface\Repository;

interface FileRepositoryInterface
{
    public function store(string $fileName, string $content): false|int;
}
