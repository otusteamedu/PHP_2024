<?php

namespace Ekonyaeva\Otus;

interface EventStoreInterface
{
    public function add(array $param);
    public function clear(): void;
    public function get(array $param): ?array;
}