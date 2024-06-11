<?php

namespace App\Infrastructure\Service\Queue;

use Closure;

interface ConsumerInterface
{
    /**
     * @param Closure $callback Функция должна принимать MessageInterface
     * @return void
     */
    public function consume(Closure $callback): void;
}
