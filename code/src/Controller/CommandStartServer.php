<?php

namespace IraYu\Controller;

use IraYu\Contract;
use IraYu\Service;

class CommandStartServer implements Contract\Controller\Command
{
    use Contract\Traits\Configurable;

    public function execute(Contract\Request $request): void
    {
        (new Service\Server($this->getConfig('socket_path')))->start();
    }
}
