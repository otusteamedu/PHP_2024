<?php

declare(strict_types=1);

namespace Asyrovatkin\Hw11\Helpers;

use Exception;

class InputFormatterToJson
{

    /**
     * @throws Exception
     */
    public function format($eventJson): array
    {
        $eventJson = preg_replace('/(?<!")(?<!\w)(\w+)(?!")(?!\w)/', '"$1"', $eventJson);
        $eventJson = preg_replace('/\:{2}/', '', $eventJson);
        $eventJson = preg_replace('/\=/', ':', $eventJson);
        $eventJson = preg_replace('/\s+/', '', $eventJson);
        $eventJson = preg_replace('/\s+/', '', $eventJson);
        $eventJson = preg_replace('~\{"event"\},~', '"eventName"', $eventJson);
        $eventJson = trim($eventJson, ',');
        $eventJson = '[' . $eventJson . ']';

        $result = json_decode($eventJson, true);
        $this->validator($result);

        return $result;
    }

    /**
     * @param $result
     * @return void
     * @throws Exception
     */
    public function validator($result): void
    {
        if (is_numeric($result) || array_key_exists('event', $result)) {
            throw new Exception('Проблема с входными данными');
        }
    }
}