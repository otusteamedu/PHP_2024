<?php
declare(strict_types=1);
namespace App;

use App\Services\Client\Client;
use App\Services\Config\Config;
use App\Services\Server\Server;

class App
{

    private string $command;
    private Config $config;
    const CONTAINER_UP = "container_up";
    const START_SERVER = "server";
    const START_CLIENT = "client";
    /**
     * App constructor.
     * @param string $argv
     */
    public function __construct(string $argv)
    {
        $this->command = $argv;
        $this->config = new Config();
    }

    public function run() {

//        if ($this->command === self::CONTAINER_UP) {
//            while (1) {
//                sleep(1);
//            }
//        }

        $conf = $this->config;

        if ($this->command === self::START_SERVER) (new Server($conf))->run();
        if ($this->command === self::START_CLIENT) (new Client($conf))->run();
    }
}