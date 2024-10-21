<?php

declare(strict_types=1);

namespace App\Infrastructure\Repository;

use App\Controller\Enum\ServiceMessage;
use App\Domain\Service\ConfigService;
use Redis;
use RedisException;

class RedisRepository
{
    private Redis $redis;

    private bool $redisStatus = false;

    private bool $auth = false;

    private bool $connect = false;

    private string $redisException = '';

    public function __construct()
    {
        $this->redis = new Redis();

        try {
            $this->connect = $this->redis->connect(ConfigService::class::get('REDIS_CONTAINER_NAME'));
        } catch (RedisException $e) {
            $this->redisException .= PHP_EOL . $e->getMessage();
        }

        try {
            $this->auth = $this->redis->auth(ConfigService::class::get('REDIS_PASSWORD'));
        } catch (RedisException $e) {
            $this->redisException .= PHP_EOL . $e->getMessage();
        }
        $this->redisStatus = $this->auth && $this->connect;
    }

    public function addRecord(string $json): string
    {
        if (!$this->redisStatus) {
            return ServiceMessage::StorageStatusError->value . $this->redisException;
        }

        $recordArray = json_decode($json, true);
        $priority    = $recordArray['priority'];
        $key         = $this->setKey($recordArray, 1, 2);
        $recordType  = $this->getKeyIndex($recordArray, 2);

        $this->saveRecordKey($recordType, $key);
        $result = $this->redis->zAdd($key, $priority, $json);

        return $result === 1 ? ServiceMessage::StoragePostSuccess->value . $recordType
                             : ServiceMessage::StoragePostError->value;
    }

    public function getRecord(string $json)
    {
        if (!$this->redisStatus) {
            return ServiceMessage::StorageStatusError->value . $this->redisException;
        }

        $paramArray = json_decode($json, true);
        $key        = $this->setKey($paramArray, 0, 0);
        $result     = $this->redis->zRevRange($key, 0, 0)[0];

        return $result ? ServiceMessage::StorageGetSuccess->value . $result
                       : ServiceMessage::StorageGetError->value . $key;
    }

    public function removeAllRecord(string $json): string
    {
        $recordType =  json_decode($json, true)['record'];
        if (!$this->redisStatus) {
            return ServiceMessage::StorageStatusError->value . $this->redisException;
        }

        $deleteAllRecord = $this->redis->del($this->getAllRecordKey($recordType));
        $deleteRecordType = $this->redis->del($recordType);

        return $deleteAllRecord && $deleteRecordType
                ? ServiceMessage::StorageRemoveSuccess->value
                : ServiceMessage::StorageRemoveError->value . $recordType;
    }

    private function saveRecordKey(string $recordType, string $key): void
    {
        $this->redis->sAdd($recordType, $key);
    }

    private function getAllRecordKey(string $recordType): false|array|Redis
    {
        return $this->redis->sMembers($recordType);
    }

    private function getKeyIndex(array $array, int $index): int|string
    {
        $keyArray = [];
        foreach ($array as $key => $value) {
            $keyArray[] = $key;
        }

        return $keyArray[$index];
    }

    private function setKey(array $array, int $conditionIndex, int $recordTypeIndex): string
    {
        $keyRecord = '';
        $recordType = '';
        $keyCondition = '';

        $recordType .= $this->getKeyIndex($array, $recordTypeIndex);
        $keyRecord .= $recordType;
        $keyCondition .= $this->getKeyIndex($array, $conditionIndex);

        foreach ($array[$keyCondition] as $param => $value) {
            $keyRecord .= ':' . $param . ':' . $value;
        }

        return $keyRecord;
    }
}
