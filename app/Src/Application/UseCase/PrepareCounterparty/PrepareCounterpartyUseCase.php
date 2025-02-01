<?php

namespace Src\Application\UseCase\PrepareCounterparty;

use Src\Application\Gateway\RedisGatewayInterface;
use Src\Domain\Interface\ConsumerInterface;

class PrepareCounterpartyUseCase
{
    private ConsumerInterface $consumer;
    private RedisGatewayInterface $redisGateway;
    public function __construct(ConsumerInterface $consumer, RedisGatewayInterface $redisGateway)
    {
        $this->consumer = $consumer;
        $this->redisGateway = $redisGateway;
    }

    public function __invoke(PrepareCounterpartyRequest $request): PrepareCounterpartyResponse
    {
        $callback = function ($msg) {
            echo "start" . PHP_EOL;
            $params = json_decode($msg->body, true);
            sleep(10);
            $this->redisGateway->setStatus($params['message_id'], 2);
            sleep(10);
            $result = [
                'claim' => rand(0, 10_000)
            ];
            $this->redisGateway->setStatus($params['message_id'], 3);
            $this->redisGateway->saveResult($params['message_id'], $result);
        };
        $this->consumer->exec('statement', $callback);
        return new PrepareCounterpartyResponse();
    }
}