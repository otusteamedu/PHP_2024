<?php

namespace Src\Application\Gateway;

interface RedisGatewayInterface
{
    public function setStatus(string $id, int $status): void;
    public function getStatus(string $id): ?int;
    public function saveResult(string $id, array $result): void;
    public function getResult(string $id): ?array;
}