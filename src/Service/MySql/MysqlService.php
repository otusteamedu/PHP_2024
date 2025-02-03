<?php

namespace KRudenko\Otus\Service\MySql;

use KRudenko\Otus\Service\SearchServiceInterface;

class MysqlService implements SearchServiceInterface
{
    public function bulk(array $document, string $index): bool
    {
        return true;
    }

    public function search(array $criteria, int $page, string $index): array
    {
        return [];
    }
}
