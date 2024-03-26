<?php

declare(strict_types=1);

namespace hw15\redis;

use hw15\StorageInterface;

class Storage implements StorageInterface
{
    public function exec(string $method, string $value): string
    {
        switch ($method) {
            default:
                return (new Test())->exec();
        }
    }

}
