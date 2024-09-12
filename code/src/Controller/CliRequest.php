<?php

namespace IraYu\Controller;

use IraYu\Contract;

class CliRequest implements \IraYu\Contract\Request
{
    protected array $properties = [];
    public function __construct()
    {
        $args = $_SERVER['argv'];
        $this->properties['type'] = ($args[1] ?? null);
    }

    public function get(string $name): mixed
    {
        return $this->properties[$name] ?? null;
    }
}
