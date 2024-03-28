<?php

namespace App\Contracts;

interface SearchInterface
{
    public function fields(): array;
    public function search(): string;
}
