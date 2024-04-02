<?php

namespace hw15;


interface StorageInterface
{
    public function add(Event $eventDto);

    public function get(): array;

    public function test();

    public function delete();
}
