<?php

declare(strict_types=1);


namespace App\Infrastructure\Main;


abstract class AbstractApplication
{

    protected static $instance;
    protected $config;

    /**
     * App constructor.
     */
    protected function __construct(array $config = [])
    {
        $this->config = $config;
    }

    protected function __clone()
    {
    }

    /**
     * @throws \Exception
     */
    public function __wakeup()
    {
        throw new \Exception("Может существовать только 1 экземпляр приложения");
    }

    /**
     * @param array $config
     * @return static
     */
    public static function getInstance(array $config = []): self
    {
        if (empty(self::$instance)) {
            self::$instance = new static($config);
        }

        return self::$instance;
    }
}
