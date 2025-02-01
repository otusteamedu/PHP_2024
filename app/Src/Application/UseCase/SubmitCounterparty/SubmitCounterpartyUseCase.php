<?php

namespace Src\Application\UseCase\SubmitCounterparty;

use Src\Application\Gateway\RedisGatewayInterface;
use Src\Domain\Interface\PublisherInterface;

class SubmitCounterpartyUseCase
{
    private PublisherInterface $publisher;
    private RedisGatewayInterface $redisGateway;
    public function __construct(PublisherInterface $publisher, RedisGatewayInterface $redisGateway)
    {
        $this->publisher = $publisher;
        $this->redisGateway = $redisGateway;
    }

    public function __invoke(SubmitCounterpartyRequest $request): SubmitCounterpartyResponse
    {
        $message = ['user_id' => $request->userId, 'inn' => $request->inn];
        $message_id = md5(time().implode('|', $message));
        $message['message_id'] = $message_id;
        $this->redisGateway->setStatus($message_id, 1);

        $this->publisher->sendMessageToChannel('statement', json_encode($message));

        return new SubmitCounterpartyResponse(
            $message_id
        );
    }
}