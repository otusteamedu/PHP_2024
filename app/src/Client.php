<?php

declare(strict_types=1);

namespace AlexanderPogorelov\Chat;

class Client
{
    private SocketManager $manager;
    private Config $config;

    public function __construct()
    {
        $this->manager = new SocketManager();
        $this->config = new Config();
    }

    /**
     * @throws \Exception
     */
    public function start(): void
    {
        echo 'Client has been started' . PHP_EOL;

        $this->manager->create();
        $this->manager->connect();
        $isRunning = true;

        while ($isRunning) {
            $message = \readline('Enter your message: ');

            if ($this->config->getStopMessage() === $message) {
                $isRunning = false;
            }

            $this->manager->write($message);

            echo 'Message has been sent to server.' . PHP_EOL;

            $message = $this->manager->read();

            if ('' !== $message) {
                echo sprintf('Server has just replied: %s.', $message) . PHP_EOL;
            }
        }

        echo 'Client closed' . PHP_EOL;
    }
}
