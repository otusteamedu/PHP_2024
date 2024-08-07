<?php

namespace app\routing\consumers;

use app\application\command\execute_tasks\Command;
use app\application\command\execute_tasks\Handler;
use app\log\service\Log;
use PhpAmqpLib\Message\AMQPMessage;

class ExecuteTasks extends BaseConsumers
{
    public function __construct(private readonly Handler $executeTasks, Log $log)
    {
        parent::__construct($log);
    }

    public function handler(AMQPMessage $msg): int
    {
        sleep(random_int(1, 10));
        $data = $msg->getBody();

        $this->executeTasks->handler(
            new Command($data['id'], [
                'execute_params' => random_int(1, 200)
            ])
        );


        return self::MSG_ACK;
    }
}
