<?php

declare(strict_types=1);

namespace Alogachev\Homework\DataMapper\Mapper;

use PDO;

abstract class BaseMapper
{
    public function __construct(
        protected PDO $pdo
    ) {
    }

    protected function buildInsertQuery(): string
    {
        return '';
    }

    protected function buildUpdateQuery(): string
    {
        return '';
    }

    protected function buildSelectQuery(): string
    {
        return '';
    }

    protected function buildDeleteQuery(): string
    {
        return '';
    }
}
