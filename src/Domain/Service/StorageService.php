<?php

declare(strict_types=1);

namespace App\Domain\Service;

use App\Domain\Interface\StorageInterface;
use App\Infrastructure\Repository\RedisRepository;

class StorageService implements StorageInterface
{
    private RedisRepository $repository;

    public function __construct() {
        $this->repository = new RedisRepository;
    }

    public function addRecord(string $json): string
    {
        return $this->repository->addRecord($json);
    }

    public function getRecord(string $json): string
    {
        return $this->repository->getRecord($json);
    }

    public function removeAllRecord(string $json): string
    {
        return $this->repository->removeAllRecord($json);
    }
}
