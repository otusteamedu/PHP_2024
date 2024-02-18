<?php

declare(strict_types=1);

namespace Rmulyukov\Hw5\Chat;

use Exception;

final readonly class Client extends AbstractChat
{
    private string $serverFile;

    public function __construct(string $clientFile, string $serverFile)
    {
        parent::__construct($clientFile);
        $this->serverFile = $this->prepareSocketFilePath($serverFile);
    }

    /**
     * @throws Exception
     */
    public function run(): void
    {
        while (true) {
            $input = readline("Type your message to server \n");

            if ($input === 'stop') {
                break;
            }

            $message = new Message($this->socket->getPath(), $this->serverFile, $input, strlen($input));
            $this->socket->sendMessage($message);
            echo "Message sent\n";

            $message = $this->socket->getMessage();
            echo sprintf("MESSAGE '%s' from server \n", $message->getMessage());
        }
    }
}
