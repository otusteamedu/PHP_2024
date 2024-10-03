<?php

declare(strict_types=1);

namespace Evgenyart\Hw12;

use Exception;

class App
{
    public function run()
    {
        $args = $_SERVER['argv'];

        $ExceptionError = "Необходимо ввести параметр `add`, `clear` либо `get`";

        if (!isset($args[1])) {
            throw new Exception($ExceptionError);
        }

        switch ($args[1]) {
            case 'add':
                Run::addEvent($args[2]);
                break;
            case 'clear':
                Run::clearEvents();
                break;
            case 'get':
                Run::getEvent($args[2]);
                break;
            default:
                throw new Exception($ExceptionError);
                break;
        }
    }
}
