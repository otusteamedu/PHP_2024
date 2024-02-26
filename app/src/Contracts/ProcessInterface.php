<?php

declare(strict_types=1);

namespace App\src\Contracts;

interface ProcessInterface
{
    public function init(): void;

    public function run(): void;
}
