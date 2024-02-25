<?php

namespace Pavelsergeevich\Hw5;

use Exception;
use Socket;
use Throwable;

class ServerApp implements Runnable
{
    public bool $isRunning;

    public SocketManager $socketManager;

    /**
     * @throws Exception
     */
    public function __construct()
    {
        $this->socketManager = new SocketManager('listener');
    }

    /**
     * @throws Throwable
     */
    public function run()
    {
        $this->isRunning = true;
        while ($this->isRunning) {
            sleep(1);
            $message = $this->socketManager->socketRead();
            if ($message === 'killmeplease') {
                $this->socketManager->socketClose()->removeSocketFile();
                $this->isRunning = false;
                echo '*F*';
            } elseif ($message) {
                echo $message . "\n";
            }
        }
    }

}