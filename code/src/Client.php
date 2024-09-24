<?php

declare(strict_types=1);

namespace Otus\Chat;

use Exception;

class Client
{
    private Socket $socket;

    /**
     * @throws Exception
     */
    public function __construct(string $socketPath)
    {
        $this->socket = new Socket($socketPath);
    }

    /**
     * @throws Exception
     */
    public function run(): void
    {
        $this->socket->connect();

        while (1) {
            $msg = readline('> You: ');
            if (!$msg) {
                continue;
            }

            $this->socket->send($msg);

            $data = $this->socket->read();
            if ($data) {
                echo '> Response: ' . $data . "\n";
            }

            if ($msg === '/exit') {
                break;
            }
        }

        $this->socket->close();
    }
}