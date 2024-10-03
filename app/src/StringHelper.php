<?php

declare(strict_types=1);

namespace Evgenyart\Hw12;

use Exception;

class StringHelper
{
    public static function parseString($str, $mode)
    {
        $request = json_decode($str, true);

        if (!is_array($request)) {
            throw new Exception('Проверьте корректность запроса');
        }

        switch ($mode) {
            case 'add':
                if (!isset($request['priority'])) {
                    throw new Exception('В запросе отсуствует параметр priority');
                }

                if (!is_numeric($request['priority'])) {
                    throw new Exception('В запросе priority не является числом');
                }

                if (!isset($request['conditions'])) {
                    throw new Exception('В запросе отсуствует параметр conditions');
                }

                if (empty($request['conditions'])) {
                    throw new Exception('В запросе передан пустой conditions');
                }

                if (!isset($request['event'])) {
                    throw new Exception('В запросе отсуствует параметр event');
                }

                if (!strlen($request['event'])) {
                    throw new Exception('В запросе передан пустой event');
                }

                return [
                    'priority' => $request['priority'],
                    'data' => json_encode(['conditions' => $request['conditions'], 'event' => $request['event']])
                ];

                break;
            case 'get':
                if (!isset($request['params'])) {
                    throw new Exception('В запросе отсуствует параметр params');
                }
                if (empty($request['params'])) {
                    throw new Exception('В запросе передан пустой params');
                }

                return $request;
                break;
        }
    }
}
