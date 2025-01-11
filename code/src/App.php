<?php

namespace Ekonyaeva\Otus;

use Ekonyaeva\Otus\AppException;
use Ekonyaeva\Otus\EventStoreInterface;
use Ekonyaeva\Otus\RedisEvents;

class App
{
    private ?string $cmd = null;
    private ?string $cmdParam = null;

    private ?EventStoreInterface $storage;

    public function __construct()
    {
        set_time_limit(0);
        mb_internal_encoding('UTF-8');

        $this->parseArg();

        $this->storage = new RedisEvents();
//        $this->storage = new MongoEvent();
    }

    public function run(): void
    {
        if (empty($this->cmd)) throw new AppException('Empty argument');
        match (strtoupper($this->cmd)) {
            'ADD' => $this->commandAdd(),
            'LOAD' => $this->commandLoadFile(),
            'GET' => $this->print($this->commandGet() ),
            'CLEAR' => $this->storage->clear()
        };
    }

    private function parseArg(): void
    {
        $opt = getopt('l:a:g:c');

        if (isset($opt['l'])) {
            $this->cmd = 'LOAD';
            $this->cmdParam = $opt['l'];
        }
        if (isset($opt['a'])) {
            $this->cmd = 'ADD';
            $this->cmdParam = $opt['a'];
        }
        if (isset($opt['g'])) {
            $this->cmd = 'GET';
            $this->cmdParam = $opt['g'];
        }
        if (isset($opt['c'])) {
            $this->cmd = 'CLEAR';
        }
    }

    private function commandAdd(): void
    {
        if (empty($this->cmdParam)) {
            throw new AppException('Add expect json string');
        }

        $json = json_decode($this->cmdParam, true);

        if ( json_last_error() === JSON_ERROR_SYNTAX) throw new AppException('Error parse json string');

        $this->storage->add($json);
    }

    private function commandGet(): ?array
    {
        if (empty($this->cmdParam)) {
            throw new AppException('Get expect json string');
        }
        $json = json_decode($this->cmdParam, true);
        if (!is_array($json)) {
            throw new AppException('Error parse json string');
        }
        return $this->storage->get($json);
    }

    private function print(?array $event): void
    {
        echo 'Event: ' . json_encode($event, JSON_UNESCAPED_UNICODE) . PHP_EOL;
    }
}