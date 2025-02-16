<?php

declare(strict_types=1);

namespace SlavaMakhov\OtusArchitectureApp\Infrastructure\Gateway;

use SlavaMakhov\OtusArchitectureApp\Application\Gateway\QueueGatewayInterface;
use SlavaMakhov\OtusArchitectureApp\Application\Gateway\QueueGatewayResponse;
use SlavaMakhov\OtusArchitectureApp\Application\Gateway\QueueGatewayRequest;
use Dotenv\Dotenv;
use Exception;
use Redis;
class BaseRedisGateway implements QueueGatewayInterface
{
    /** @var ?BaseRedisGateway */
    private static ?BaseRedisGateway $instance = null;

    /** @var Redis */
    public Redis $redis;

    public function __construct()
    {
        $dotenv = Dotenv::createImmutable(__DIR__ . '/../../');
        $dotenv->load();

        try {
            $this->redis = new Redis();
            $this->redis->connect($_ENV['REDIS_HOST'], (int)$_ENV['REDIS_PORT']);
        } catch (Exception $e) {
            exit('Ошибка подключения к Redis: ' . $e->getMessage());
        }
    }

    /**
     * @throws Exception
     */
    public function saveEvent(QueueGatewayRequest $request): QueueGatewayResponse
    {
        $id = $this->getTotal();
        $id++;
        $priority = $this->redis->executeRaw(["GET", "priority:{$request->event->getPriority()->getValue()}"], false);

        if (!empty($priority) && (int)$priority === 1) {
            throw new Exception("Priority {$request->event->getPriority()->getValue()} exists");
        }

        $this->redis->executeRaw(["ZADD", "priority", $request->event->getPriority()->getValue(), $id], false);

        $this->redis->executeRaw(["SET", "priority:{$request->event->getPriority()->getValue()}", 1], false);

        foreach ($request->event->getConditionList()->getConditionList() AS $key => $value) {
            $this->redis->executeRaw(["RPUSH", "$key:$value", $id], false);
        }

        $this->redis->executeRaw(["SET", "params:$id", json_encode(array_keys($request->event->getConditionList()->getConditionList()))], false);

        $this->redis->executeRaw(["SET", "events:$id", $request->event->getName()->getValue()], false);

        return new QueueGatewayResponse($id);
    }

    /**
     * Метод устанавливает ключ и значение в Redis
     *
     * @param string $key
     * @param array $data
     *
     * @return void
     * @throws Exception
     */
    public function set(string $key, array $data): void
    {
        $this->redis->set($key, json_encode($data));
    }

    /**
     * Метод получает значение по ключу из Redis
     *
     * @param string $key
     *
     * @return array|null
     * @throws Exception
     */
    public function get(string $key): ?array
    {
        $data = $this->redis->get($key);

        return $data ? json_decode($data, true) : null;
    }

    /**
     * Получить все значения из Redis
     * по определенному паттерну ключа
     *
     * @param string $pattern
     *
     * @return array
     * @throws Exception
     */
    public function getAll(string $pattern): array
    {
        $results = [];
        $keys = $this->redis->keys($pattern);

        foreach ($keys as $key) {
            $results[$key] = $this->get($key);
        }

        return $results;
    }

    /**
     * Удалить значение из Redis по определенному ключу
     *
     * @param string $key
     *
     * @return void
     * @throws Exception
     */
    public function delete(string $key): void
    {
        $this->redis->del($key);
    }

    /**
     * Метод удаляет все значения из Redis
     * по определенному паттерну ключа
     *
     * @param string $pattern
     *
     * @return void
     * @throws Exception
     */
    public function clear(string $pattern): void
    {
        $keys = $this->redis->keys($pattern);

        foreach ($keys as $key) {
            $this->delete($key);
        }
    }

    /**
     * Метод проверяет был ли создан уже
     * объект или нет
     *
     * @return static
     */
    public static function getInstance(): self
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }

        return self::$instance;
    }
}
