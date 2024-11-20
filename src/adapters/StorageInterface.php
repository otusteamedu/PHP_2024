<?php

namespace hw15\adapters;

use hw15\entities\EventEntity;

interface StorageInterface
{
    public function add(EventEntity $entity);

    public function get(): array;

    public function test();

    public function delete();
}
