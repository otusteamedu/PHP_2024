<?php

namespace KRudenko\Otus\Service;

interface SearchServiceInterface
{
    public function bulk(array $document, string $index): bool;

    public function search(array $criteria, int $page, string $index): array;
}
