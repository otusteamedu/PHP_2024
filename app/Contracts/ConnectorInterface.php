<?php

namespace App\Contracts;

interface ConnectorInterface
{

    public function setKey(string $key, mixed $value);
    public function dropKey(string $key);
    public function update(string $key, mixed $value);
    public function search(string $key);
    public function clear();
    public function getAll();
}
