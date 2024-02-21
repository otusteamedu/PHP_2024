<?php

declare(strict_types=1);

namespace AleksandrOrlov\Php2024;

use AleksandrOrlov\Php2024\Service\NetworkInterface;
use Exception;
use Generator;

class App
{
    /**
     * @throws Exception
     */
    public function run(): Generator
    {
        if (empty($_SERVER['argv'][1])) {
            throw new Exception('Не передан параметр запуска');
        }

        $className = __NAMESPACE__ . '\Service\\' . ucfirst($_SERVER['argv'][1]);

        /**
         * @var NetworkInterface $networkService
         */
        if (class_exists($className) && ($networkService = new $className()) instanceof NetworkInterface) {
            return $networkService->run();
        } else {
            throw new Exception('Сервис: ' . $className . ' не найден');
        }
    }
}
