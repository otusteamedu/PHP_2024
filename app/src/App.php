<?php

declare(strict_types=1);

namespace Evgenyart\ElasticHomework;

use Exception;

class App
{
    public function run()
    {
        $args = $_SERVER['argv'];

        $ExceptionError = "Необходимо ввести параметр `init` либо `search`";

        if (!isset($args[1])) {
            throw new Exception($ExceptionError);
        }

        switch ($args[1]) {
            case 'init':
                Run::InitSrorage();
                break;
            case 'search':
                Run::SearshInBase($args);
                break;
            default:
                throw new Exception($ExceptionError);
                break;
        }
    }
}
