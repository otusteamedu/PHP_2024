<?php

declare(strict_types=1);

namespace App\Handlers;

use App\Helpers\ConsoleHelper;
use PhpAmqpLib\Message\AMQPMessage;

class MessageHandler
{
    public function __invoke(AMQPMessage $msg): void
    {
        /** @var $data array{id:string, start_date:string, end_date:string, email:string} */
        $data = json_decode($msg->getBody(), true);
        ConsoleHelper::output($data);
    }
}
