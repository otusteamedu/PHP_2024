<?php

declare(strict_types=1);

namespace App\Interface;

interface StorageInterface
{
    public function addRecord(string $string): string;

    public function getRecord(string $string): string;

    public function removeAllRecord(string $string): string;
}
