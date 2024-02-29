<?php

declare(strict_types=1);

namespace RailMukhametshin\Hw\Commands;

use Exception;
use RailMukhametshin\Hw\Socket\SocketServer;

class StartSocketServerCommand extends AbstractCommand
{
    /**
     * @throws Exception
     */
    public function execute(): void
    {
        $this->formatter->output('Started socket server');
        $server = new SocketServer($this->getConfigManager()->get('unix_file_path'));
        $server->start();
        $this->formatter->output('Closed socket server');
    }
}
