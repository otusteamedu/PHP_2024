<?php

declare(strict_types=1);

namespace SlavaMakhov\OtusRedisApp\Services;

interface RedisServiceInterface
{
    /**
     * Метод устанавливает ключ и значение в Redis
     *
     * @param string $key
     * @param array $data
     *
     * @return void
     */
    public function set(string $key, array $data): void;

    /**
     * Метод получает значение по ключу из Redis
     *
     * @param string $key
     *
     * @return array|null
     */
    public function get(string $key): ?array;

    /**
     * Получить все значения из Redis
     * по определенному паттерну ключа
     *
     * @param string $pattern
     *
     * @return array
     */
    public function getAll(string $pattern): array;

    /**
     * Удалить значение из Redis по определенному ключу
     *
     * @param string $key
     *
     * @return void
     */
    public function delete(string $key): void;

    /**
     * Метод удаляет все значения из Redis
     * по определенному паттерну ключа
     *
     * @param string $pattern
     *
     * @return void
     */
    public function clear(string $pattern): void;

    /**
     * Метод проверяет был ли создан уже
     * объект или нет
     *
     * @return static
     */
    public static function getInstance(): self;
}