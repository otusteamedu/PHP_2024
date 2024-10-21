<?php

namespace App\Domain\Service;

use App\Domain\Interface\StorageInterface;
use App\Infrastructure\Repository\ElasticsearchRepository;

class ElasticsearchService implements StorageInterface
{
    private ElasticsearchRepository $repository;

    public function __construct() 
    {
        $this->repository = new ElasticsearchRepository;
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

    public function createIndex(string $json): string
    {
        return $this->repository->createIndex($json);
    }

    public function getIndexInfo(string $json): string
    {
        return $this->repository->getIndexInfo($json);
    }

    public function bulk(string $json): string
    {
        return $this->repository->bulk($json);
    }

    public function removeRecord(string $json): string
    {
        return $this->repository->removeRecord($json);
    }

    public function search(string $json): string
    {
        return $this->repository->search($json);
    }
}
