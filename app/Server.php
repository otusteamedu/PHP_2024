<?php
declare(strict_types=1);

namespace Hukimato\SocketChat;

use Exception;

class Server extends SocketClient
{
    /**
     * @throws Exception
     */
    public function run(): void
    {
        $socketName = parent::getSocketNameFromServerName($this->name);
        if (file_exists($socketName)) {
            unlink($socketName);
        }

        $socketWrapper = new SocketWrapper();
        $socketWrapper->bind($socketName);
        $socketWrapper->listen();
        $socketWrapper->accept();

        while (true) {
            $data = $socketWrapper->read();
            echo $data . PHP_EOL;

            if (preg_match('#/quit#', $data, $match)) {
                echo 'Прекращаю работу' . PHP_EOL;
                $socketWrapper->write("closed");
                break;
            }
            $socketWrapper->write("confirmed");
        }
        $socketWrapper->close();
        echo 'Connection closed' . PHP_EOL;
    }
}