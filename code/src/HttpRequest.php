<?php

namespace IraYu\OtusHw4;

class HttpRequest implements Request
{
    protected array $properties;
    public function __construct(array $properties)
    {
        $this->properties = $properties;

        return $this;
    }

    public function get(string $name): mixed
    {
        return $this->properties[$name] ?? null;
    }
}
