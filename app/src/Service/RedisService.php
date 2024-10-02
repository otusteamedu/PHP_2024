<?php

declare(strict_types=1);

namespace App\Service;

use App\Enum\ServiceMessage;
use Redis;
use RedisException;

class RedisService
{
    /**
     * @var Redis $redis
     */
    private Redis $redis;

    /**
     * @var bool
     */
    private bool $redisStatus = false;

    /**
     * @var bool|Redis $auth
     */
    private bool $auth = false;

    /**
     * @var bool $connect
     */
    private bool $connect = false;

    /**
     * @var string $redisException
     */
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

    /**
     * @param string $string
     * @return string
     * @throws RedisException
     */
    public function addRecord(string $string): string
    {
        if (!$this->redisStatus) {
            return ServiceMessage::StorageStatusError->value . $this->redisException;
        }

        $recordArray = json_decode($string, true);
        $priority    = $recordArray['priority'];
        $key         = $this->setKey($recordArray, 1, 2);
        $recordType  = $this->getKeyIndex($recordArray, 2);

        $this->saveRecordKey($recordType, $key);
        $result = $this->redis->zAdd($key, $priority, $string);

        return $result === 1 ? ServiceMessage::StoragePostSuccess->value . $recordType
                             : ServiceMessage::StoragePostError->value;
    }

    /**
     * @param string $string
     * @return string
     * @throws RedisException
     */
    public function getRecord(string $string)
    {
        if (!$this->redisStatus) {
            return ServiceMessage::StorageStatusError->value . $this->redisException;
        }

        $paramArray = json_decode($string, true);
        $key        = $this->setKey($paramArray, 0, 0);
        $result     = $this->redis->zRevRange($key, 0, 0)[0];

        return $result ? ServiceMessage::StorageGetSuccess->value . $result
                       : ServiceMessage::StorageGetError->value . $key;
    }

    /**
     * @param string $recordType
     * @return string
     * @throws RedisException
     */
    public function removeAllRecord(string $recordType): string
    {
        if (!$this->redisStatus) {
            return ServiceMessage::StorageStatusError->value . $this->redisException;
        }

        $deleteAllRecord = $this->redis->del($this->getAllRecordKey($recordType));
        $deleteRecordType = $this->redis->del($recordType);

        return $deleteAllRecord && $deleteRecordType
                ? ServiceMessage::StorageRemoveSuccess->value
                : ServiceMessage::StorageRemoveError->value . $recordType;
    }

    /**
     * @param string $recordType
     * @param string $key
     * @return void
     */
    private function saveRecordKey(string $recordType, string $key): void
    {
        $this->redis->sAdd($recordType, $key);
    }

    /**
     * @param string $recordType
     * @return false|array|Redis
     * @throws RedisException
     */
    private function getAllRecordKey(string $recordType): false|array|Redis
    {
        return $this->redis->sMembers($recordType);
    }

    /**
     * @param array $array
     * @param int $index
     * @return int|mixed|string
     */
    private function getKeyIndex(array $array, int $index)
    {
        $keyArray = [];
        foreach ($array as $key => $value) {
            $keyArray[] = $key;
        }

        return $keyArray[$index];
    }

    /**
     * @param array $array
     * @param int $conditionIndex
     * @param int $recordTypeIndex
     * @return string
     */
    private function setKey(array $array, int $conditionIndex, int $recordTypeIndex)
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
