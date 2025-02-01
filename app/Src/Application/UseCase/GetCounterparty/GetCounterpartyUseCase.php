<?php

namespace Src\Application\UseCase\GetCounterparty;

use Src\Application\Gateway\RedisGatewayInterface;
use Src\Domain\Interface\PublisherInterface;

class GetCounterpartyUseCase
{
    private RedisGatewayInterface $redisGateway;
    public function __construct(RedisGatewayInterface $redisGateway)
    {
        $this->redisGateway = $redisGateway;
    }

    public function __invoke(GetCounterpartyRequest $request): GetCounterpartyResponse
    {
        $status_id = $this->redisGateway->getStatus($request->message_id);
        $result = [];
        if ($status_id === 3) {
            $result = $this->redisGateway->getResult($request->message_id);
        }

        return new GetCounterpartyResponse(
            $status_id, $result
        );
    }
}