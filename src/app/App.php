<?php

declare(strict_types=1);

namespace ChatOtus\App;

use ErrorException;
use Noodlehaus\Config;

class App
{
    private SocketChat $service;

    private Config $conf;

    public function __construct(string $params)
    {
        $this->conf = Config::load('../config.ini');
        if ($params === "server") {
            $this->service = new Server();
        } else {
            $this->service = new Client();
        }
    }

    /**
     * @throws ErrorException
     */
    public function run(): void
    {
        $this->service->run($this->conf->get('app.socket_path'));
    }
}
