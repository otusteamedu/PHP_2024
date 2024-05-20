<?php
declare(strict_types=1);

namespace App\Services\Client;

use App\Services\Socket\Socket;

class Client extends Socket
{
    public function run() {

        $socket = $this->prepareClient();

        echo $this->read($socket);
        $exit = ($this->socketConst)["MSG_EXIT"];
        while (true) {

            $line = readline(PHP_EOL."Введите сообщение:  ");
            if ($line == '') continue;

            if ($this->write($socket,$line) === false) {
                $this->close($socket);
                break;
            }

            $out = $this->read($socket);

            echo PHP_EOL.$out.PHP_EOL;

            if ($line === $exit) {
                break;
            }
        }
        $this->close($socket);
    }



}