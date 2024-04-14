<?php

namespace App\Traits;

trait Singleton
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
