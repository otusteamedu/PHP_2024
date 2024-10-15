<?php

declare(strict_types=1);

namespace Otus\App;

use Exception;
use Otus\App\Services\EventService;
use RedisException;

class App
{
    /**
     * @throws Exception
     */
    public function run(): void
    {
        try {
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
        } catch (\Exception $e) {
            // Имитация логирования и вывода сообщения об ошибке
            echo $e->getMessage();
        }

    }

    /**
     * @throws Exception
     */
    public function add(): void
    {
        (new EventService())->newEvent();
    }

    /**
     * @return void
     * @throws RedisException
     */
    public function clear(): void
    {
        (new EventService())->clearAll();
    }

    /**
     * @return void
     * @throws RedisException
     */
    public function get(): void
    {
        (new EventService())->getEvent();
    }
}
