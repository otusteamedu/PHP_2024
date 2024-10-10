<?php

declare(strict_types=1);

namespace Otus\App;

use Exception;
use Otus\App\Redis\Data;
use RedisException;

class App
{
    /**
     * @throws Exception
     */
    public function run(): void
    {
        switch ($_SERVER['argv'][1]) {
            case 'add':
                $this->add();
                break;
            case 'clear':
                $this->clear();
                break;
            case 'get':
                $this->get();
                break;
            default:
                throw new Exception('ERROR: No action specified. Use `add`, `get` or `clear`');
        }
    }

    /**
     * @throws Exception
     */
    public function add(): void
    {
        (new Data())->newEvent();
    }

    /**
     * @return void
     * @throws RedisException
     */
    public function clear(): void
    {
        (new Data())->clearAll();
    }

    /**
     * @return void
     * @throws RedisException
     */
    public function get(): void
    {
        (new Data())->getEvent();
    }
}
