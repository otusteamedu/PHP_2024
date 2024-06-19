<?php

declare(strict_types=1);

namespace Kagirova\Hw14\Domain\Repository;

interface RepositoryInterface
{
    public function __construct(string $host, string $user, string $password);
    public function search($params);
}
