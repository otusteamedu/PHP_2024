<?php

declare(strict_types=1);

namespace Asyrovatkin\Hw19\Services\Bank;


use Asyrovatkin\Hw19\Infrastructure\RabbitConnect;
use Exception;

class Bank
{
    /**
     * @throws Exception
     */
    public function requestBalance($data)
    {
        (new RabbitConnect())->sengMsgToQueue($data);
    }

}