<?php

declare(strict_types=1);

namespace RailMukhametshin\Hw\Commands;

use RailMukhametshin\Hw\Socket\SocketClient;

class StartSocketClientCommand extends AbstractCommand
{
    public function execute(): void
    {
        $this->formatter->output('Started socket client');
        $client = new SocketClient($this->getConfigManager()->get('unix_file_path'));
        $client->start();
        $this->formatter->output('Closed socket client');
    }
}
