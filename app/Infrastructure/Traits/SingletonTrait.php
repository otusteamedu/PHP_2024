<?php

declare(strict_types=1);

namespace App\Infrastructure\Traits;

trait SingletonTrait
{
    static ?self $instance = null;

    public static function getInstance(): ?self
    {
        if (is_null(static::$instance)) {
            static::$instance = new static();
        }
        return static::$instance;
    }

    public function __construct()
    {
    }

    public function __clone()
    {
    }

    public function __wakeup()
    {
    }
}
