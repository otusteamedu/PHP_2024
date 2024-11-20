<?php

namespace Kagirova\Hw15;

use Kagirova\Hw15\Application\ClearEventUseCase;
use Kagirova\Hw15\Application\GetEventUseCase;
use Kagirova\Hw15\Application\SetEventUseCase;
use Kagirova\Hw15\Infrastructure\RedisStorage;

class App
{
    private RedisStorage $redisStorage;

    public function __construct()
    {
        $this->redisStorage = new RedisStorage();
    }

    public function run($args)
    {
        if (empty($args[1])) {
            throw new \Exception('Must have an argument');
        }
        $options = getopt('f:p:c:e:');

        switch ($options['f']) {
            case 'get':
                $getEventUseCase = new GetEventUseCase($this->redisStorage);
                $getEventUseCase->run($options);
                break;
            case 'set':
                $setEventUseCase = new SetEventUseCase($this->redisStorage);
                $setEventUseCase->run($options);
                break;
            case 'clear':
                $clearEventUseCase = new ClearEventUseCase($this->redisStorage);
                $clearEventUseCase->run();
                break;
            default:
                throw new \Exception('Must have a function');
        }
    }
}
