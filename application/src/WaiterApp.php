<?php

namespace Pavelsergeevich\Hw5;

use Exception;
use Throwable;

/**
 * Это класс заглушка, нужный только для того, чтобы запустить бесконечные контейнеры
 */
class WaiterApp implements Runnable
{
    /**
     * @throws Exception
     */
    public function __construct()
    {
        echo 'Waiter is created' . PHP_EOL;
    }

    /**
     * @throws Throwable
     */
    public function run()
    {
        echo 'Waiter is running' . PHP_EOL;
        while (true) {
            sleep(1000);
        }
    }

}
