<?php

declare(strict_types=1);

namespace AlexanderPogorelov\Chat;

class Server
{
    private SocketManager $manager;

    public function __construct()
    {
        $this->manager = new SocketManager();
    }

    public function start(): void
    {
        echo 'Server started' . PHP_EOL;

        $this->manager->create(true);
        $this->manager->bind();
        $this->manager->listen();
        $connection = $this->manager->accept();

        $isRunning = true;

        while ($isRunning) {
            $message = $this->manager->read($connection);

            if ($this->manager->isStopMessage($message)) {
                $isRunning = false;
            }

            if ('' !== trim($message)) {
                $this->manager->write(sprintf('Received %d bytes', strlen($message)), $connection);

                echo sprintf('Message has been received from client: %s', $message) . PHP_EOL;
            }
        }

        $this->manager->close($connection);
        $this->manager->close();

        echo 'Server closed' . PHP_EOL;
    }
}
