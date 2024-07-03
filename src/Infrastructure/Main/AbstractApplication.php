<?php

declare(strict_types=1);

namespace App\Infrastructure\Main;

use \App\Infrastructure\Main\ApplicationInterface;

abstract class AbstractApplication implements ApplicationInterface
{
    protected static $instance;
    protected $config;

    public function __construct(array $config = [])
    {
        $this->config = $config;
    }

    public static function setInstance(ApplicationInterface $application): void
    {
        self::$instance = $application;
    }

    public static function getInstance(): self
    {
        if (empty(self::$instance)) {
            throw new \Exception("Application instance not set");
        }

        return self::$instance;
    }

    public function getParam(string $paramName)
    {
        return $this->config[$paramName] ?? null;
    }
}
