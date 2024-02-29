<?php

declare(strict_types=1);

namespace App\src;

use App\src\Socket\SocketProcessesResolver;
use Exception;

class App
{
    private SocketProcessesResolver $socketResolver;

    public function __construct()
    {
        $this->socketResolver = new SocketProcessesResolver();
    }

    /**
     * @throws Exception
     */
    public function run(): \Fiber
    {
        return $this->socketResolver->runProcess();
    }
}
