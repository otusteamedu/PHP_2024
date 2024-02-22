<?php

declare(strict_types=1);

namespace Kiryao\Sockchat\Chat;

use Kiryao\Sockchat\Config\Exception\ConfigKeyIsEmptyException;
use Kiryao\Sockchat\Config\Exception\SocketConstantNotFoundException;
use Kiryao\Sockchat\Socket\Server\Socket;
use Kiryao\Sockchat\Socket\Server\Exception\ErrorSocketReceiveException;
use Kiryao\Sockchat\Socket\Server\Exception\ErrorSocketListenException;
use Kiryao\Sockchat\Socket\Server\Exception\ErrorSocketBindException;
use Kiryao\Sockchat\Socket\Server\Exception\ErrorSocketAcceptException;
use Kiryao\Sockchat\Socket\Abstract\Exception\ErrorSocketWriteException;
use Kiryao\Sockchat\Socket\Abstract\Exception\ErrorSocketCreateException;
use Kiryao\Sockchat\Config\Exception\ConfigKeyNotFoundException;

class ServerChat implements ChatInterface
{

    /**
     * @throws ConfigKeyNotFoundException
     * @throws ErrorSocketAcceptException
     * @throws ErrorSocketBindException
     * @throws ErrorSocketCreateException
     * @throws ErrorSocketListenException
     * @throws ErrorSocketReceiveException
     * @throws ErrorSocketWriteException
     * @throws ConfigKeyIsEmptyException
     * @throws SocketConstantNotFoundException
     */
    public function run(): void
    {
        $socket = (new Socket())->create()->bind()->listen()->accept();

        while (true) {
            $inputMessage = $socket->readMessage();

            if ($inputMessage === '/exit') {
                break;
            }

            $outputMessage = sprintf("Server received number of bytes: %s bytes.", mb_strlen($inputMessage));

            $socket->write($outputMessage);
        }

        $socket->close();
    }
}
