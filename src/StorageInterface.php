<?php

namespace hw15;

interface StorageInterface
{
    public function exec(string $method, string $value): string;
}
