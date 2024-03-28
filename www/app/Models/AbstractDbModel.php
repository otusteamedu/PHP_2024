<?php

declare(strict_types=1);

namespace Hukimato\RedisApp\Models;

interface AbstractDbModel
{
    static function find(array $params): static;

    public function save(): bool;

    static function deleteAll(): bool;
}
