<?php

declare(strict_types=1);

namespace app\routing\consumers;

use PhpAmqpLib\Message\AMQPMessage;

interface LocalConsumerInterface
{
    public function handler(AMQPMessage $msg);
}
