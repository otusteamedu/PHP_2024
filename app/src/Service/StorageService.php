<?php

declare(strict_types=1);

namespace App\Service;

use App\Interface\StorageInterface;
use RedisException;

class StorageService implements StorageInterface
{
    /**
     * @var RedisService $recordService
     */
    private RedisService $recordService;

    public function __construct()
    {
        $this->recordService = new RedisService();
    }

    /**
     * @param string $string
     * @return string
     * @throws RedisException
     */
    public function addRecord(string $string): string
    {
        return $this->recordService->addRecord($string);
    }

    /**
     * @param string $string
     * @return string
     * @throws RedisException
     */
    public function getRecord(string $string): string
    {
        return $this->recordService->getRecord($string);
    }

    /**
     * @param string $string
     * @return string
     * @throws RedisException
     */
    public function removeAllRecord(string $string): string
    {
        return $this->recordService->removeAllRecord($string);
    }
}
