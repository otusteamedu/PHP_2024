<?php

namespace Redis;

class RedisConnection
{
    private $redis;
    private $host;
    private $port;
    private $auth;

    public function __construct($config)
    {
        $this->host = $config["host"];
        $this->port = $config["port"];
        $this->auth = $config["auth"];
        $this->redis = new \Redis();
    }

    public function connect()
    {
        try {
            $this->redis->connect($this->host, $this->port);
            $this->redis->auth($this->auth);

            if ($this->redis->ping()) {
                echo "Successful connection to Redis" . "<br>";
            } else {
                echo "Failed to connect to Redis" . "<br>";
            }
        } catch (\Exception $e) {
            echo "Connection error: " . $e->getMessage() . "<br>";
        }
    }
}
