<?php

declare(strict_types=1);

namespace Otus\App;

use Exception;
use Otus\App\Redis\Data;

class App
{
    public function run()
    {
        switch ($_SERVER['argv'][1]) {
            case 'add':
                return $this->add();
            case 'clear':
                return $this->clear();
            case 'get':
                return $this->get();
            default:
                throw new Exception('ERROR: No action specified. Use `add`, `get` or `clear`');
        }
    }

    public function add()
    {
        (new Data())->newEvent();
    }

    public function clear()
    {
        (new Data())->clearAll();
    }

    public function get()
    {
        (new Data())->getEvent();
    }
}
