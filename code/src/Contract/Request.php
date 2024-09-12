<?php

namespace IraYu\Contract;

interface Request
{
    public function get(string $name): mixed;
}
