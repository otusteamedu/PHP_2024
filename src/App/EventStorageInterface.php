<?php

namespace VSukhov\Hw11\App;

interface EventStorageInterface
{
    public function add(array $event);

    public function clear();

    public function getBest(array $params);
}