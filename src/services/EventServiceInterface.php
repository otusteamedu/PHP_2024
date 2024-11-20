<?php

namespace hw15\services;

interface EventServiceInterface
{
    public function delete();

    public function test();

    public function search(string $value);

    public function init();
}
