<?php

namespace App\DataMapper;

class LazyLoader
{
    private $callback;

    public function __construct($callback)
    {
        $this->callback = $callback;
    }

    public function __invoke()
    {
        return call_user_func($this->callback);
    }
}