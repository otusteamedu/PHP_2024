<?php

declare(strict_types=1);

namespace Evgenyart\Hw13;

use Exception;

class CommandHelper
{
    public static function checkParams($params, $mode)
    {
        $arAvailableFields = ['name', 'original_name', 'release_date', 'rating', 'duration', 'description'];

        switch ($mode) {
            case 'select':
            case 'delete':
                if (!isset($params[2])) {
                    throw new Exception('В запросе необходимо передать id записи');
                }
                if (!is_numeric($params[2])) {
                    throw new Exception('В запросе id записи должен быть числом');
                }
                return $params[2];
                break;

            case 'update':
                if (!isset($params[2])) {
                    throw new Exception('В запросе необходимо передать id записи');
                }
                if (!is_numeric($params[2])) {
                    throw new Exception('В запросе id записи должен быть числом');
                }
                if (!isset($params[3])) {
                    throw new Exception('В запросе необходимо передать наименование обновляемого поля');
                }
                if (!in_array($params[3], $arAvailableFields)) {
                    throw new Exception('Поле для обновления может быть из списка: ' . implode(', ', $arAvailableFields));
                }
                if (!isset($params[4])) {
                    throw new Exception('В запросе необходимо передать значение обновляемого поля');
                }
                return ['id' => $params[2], 'key' => $params[3], 'value' => $params[4]];
                break;

            case 'insert':
                if (!isset($params[2]) || !isset($params[3]) || !isset($params[4]) || !isset($params[5]) || !isset($params[6]) || !isset($params[7])) {
                    throw new Exception('В запросе необходимо 6 параметров в такой последовательности: name original_name release_date rating duration description');
                }
                return [
                    'name' => $params[2],
                    'original_name' => $params[3],
                    'release_date' => $params[4],
                    'rating' => $params[5],
                    'duration' => $params[6],
                    'description' => $params[7]
                ];
                break;
        }
    }
}
