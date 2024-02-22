<?php

declare(strict_types=1);

namespace Kiryao\Sockchat\Chat;

use Kiryao\Sockchat\Config\Exception\ConfigKeyIsEmptyException;
use Kiryao\Sockchat\Config\Exception\SocketConstantNotFoundException;
use Kiryao\Sockchat\Socket\Client\Socket;
use Kiryao\Sockchat\Socket\Client\Exception\ErrorSocketConnectException;
use Kiryao\Sockchat\Socket\Abstract\Exception\ErrorSocketWriteException;
use Kiryao\Sockchat\Socket\Abstract\Exception\ErrorSocketCreateException;
use Kiryao\Sockchat\Config\Exception\ConfigKeyNotFoundException;
use Kiryao\Sockchat\Socket\Server\Exception\ErrorSocketReceiveException;

class ClientChat implements ChatInterface
{

    /**
     * @throws ConfigKeyNotFoundException
     * @throws ErrorSocketConnectException
     * @throws ErrorSocketCreateException
     * @throws ErrorSocketReceiveException
     * @throws ErrorSocketWriteException
     * @throws ConfigKeyIsEmptyException
     * @throws SocketConstantNotFoundException
     */
    public function run(): void
    {
        $socket = (new Socket())->create()->connect();

        while (true) {
            $outputMessage = $socket->waitInputMessage();

            $socket->write($outputMessage);

            if ($outputMessage === '/exit') {
                break;
            }

            echo $socket->readMessage() . PHP_EOL;
        }

        $socket->close();
    }
}
