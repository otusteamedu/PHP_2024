<?php

namespace Builov\RedisApp;

interface DbConnector
{
    /**
     * @return mixed
     */
    public function flushDb(): mixed;

    /**
     * @param string $key
     * @param string $value
     * @return mixed
     */
    public function addToSet(string $key, string $value): mixed;

    /**
     * @param string $key
     * @param array $values
     * @return mixed
     */
    public function addToHashMulti(string $key, array $values): mixed;

    /**
     * @param string $key
     * @return array
     */
    public function getSetMembers(string $key): array;

    /**
     * @param string $key
     * @return array
     */
    public function getHashMembers(string $key): array;
}