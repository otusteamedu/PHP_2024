<?php

declare(strict_types=1);

namespace App\Domain\Interface;

interface StorageInterface
{
    public function addRecord(string $json): string;

    public function getRecord(string $json): string;

    public function removeAllRecord(string $json): string;
}
