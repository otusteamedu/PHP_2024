<?php

declare(strict_types=1);

namespace App\Processor;

use App\Consumer\RequestConsumer;
use App\Dictionary\QueueDictionary;
use Predis\Client as RedisClient;

class RedisProcessor implements ProcessorInterface
{
    private RedisClient $redis;
    private RequestConsumer $requestConsumer;

    public function __construct(RedisClient $redis, RequestConsumer $requestConsumer)
    {
        $this->redis = $redis;
        $this->requestConsumer = $requestConsumer;
    }

    public function processQueue(): void
    {
        while (true) {
            $msg = $this->redis->rpop(QueueDictionary::RequestQueue->value);
            if ($msg) {
                $this->requestConsumer->consume($msg);
            }
            sleep(1);
        }
    }
}
