<?php
declare(strict_types=1);

namespace App\Domain\Client;


use App\Domain\TransportInterface\TransportInterface;

class Client
{
    public function run(TransportInterface $transport) {

        $transport->prepareClient();

        echo $transport->read();
        $exit = $transport->getExitKey();
        while (true) {

            $line = readline(PHP_EOL."Введите сообщение:  ");
            if ($line == '') continue;

            if ($transport->write($line) === false) {
                $transport->close();
                break;
            }

            $out = $transport->read();

            echo PHP_EOL.$out.PHP_EOL;

            if ($line === $exit) {
                break;
            }
        }
        $transport->close();
    }



}