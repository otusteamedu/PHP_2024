<?php

namespace Tests;

use Ratchet\ConnectionInterface;

class TestConnection implements ConnectionInterface
{
    public $resourceId;
    public $remoteAddress;
    public $sentData = [];

    public function send($data): void
    {
        $this->sentData[] = $data;
    }

    public function close(): void
    {

    }
}