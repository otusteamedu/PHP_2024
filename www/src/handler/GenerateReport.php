<?php

namespace Ahor\Hw19\handler;

use PhpAmqpLib\Message\AMQPMessage;

class GenerateReport
{

    public function __invoke(AMQPMessage $msg): void
    {
        /** @var $data array{id:string, start_date:string, end_date:string, email:string} */
        $data = json_decode($msg->body, true, 512, JSON_THROW_ON_ERROR);
        echo $msg->body;
    }
}
