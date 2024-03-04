<?php

declare(strict_types=1);

namespace Alogachev\Homework;

use Alogachev\Homework\Interface\IRun;

class Client implements IRun
{
    public function __construct(
        private readonly string $stopWord,
        private readonly SocketManager $manager,
    ) {
    }

    public function run(): void
    {
        echo "Работает клиент!" . PHP_EOL;
        $this->manager->createAndConnect();

        while (true) {
            $msg = readline("Write something: ");

            if (!$msg) {
                continue;
            }

            if (trim($msg) === $this->stopWord) {
                $this->manager->close();
                break;
            }

            $this->manager->write($msg);

            $answer = $this->manager->read();

            if ($answer === '') {
                continue;
            }

            echo $answer . PHP_EOL;
        }
    }
}
