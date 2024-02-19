<?php

declare(strict_types=1);

namespace AleksandrOrlov\Php2024;

use AleksandrOrlov\Php2024\Service\NetworkInterface;
use Exception;

class App
{
    /**
     * @throws Exception
     */
    public function run()
    {
        if (empty($_SERVER['argv'][1])) {
            throw new Exception('Не передан параметр запуска');
        }

        $className = __NAMESPACE__ . '\Service\\' . ucfirst($_SERVER['argv'][1]);

        if (class_exists($className) && ($networkService = new $className()) instanceof NetworkInterface) {
            $networkService->run();
        } else {
            throw new Exception('Сервис: ' . $className . ' не найден');
        }
    }
}
