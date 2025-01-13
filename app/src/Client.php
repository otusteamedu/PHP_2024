<?php

namespace AnatolyShilyaev\Hw11;

use Predis\Client as PredisClient;

class Client
{
    public PredisClient $client;

    public function __construct()
    {
        $this->client = new PredisClient([
            'scheme'   => 'tcp',
            'host'     => 'redis',
            'port'     => 6379,
            'password' => 'password',
            'database' => 0,
        ]);
    }
}
