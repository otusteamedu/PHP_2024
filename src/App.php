<?php

namespace PenguinAstronaut\App;

use PenguinAstronaut\App\Exceptions\AppInvalidCliCommand;
use PenguinAstronaut\App\Exceptions\SocketAcceptException;
use PenguinAstronaut\App\Exceptions\SocketBindException;
use PenguinAstronaut\App\Exceptions\SocketConnectException;
use PenguinAstronaut\App\Exceptions\SocketCreateException;
use PenguinAstronaut\App\Exceptions\SocketListenException;

class App
{
    public function run(): void
    {
        global $argv;

        try {
            if ($argv[1] === 'server') {
                $socketApp = new SocketServer();
            } elseif ($argv[1] === 'client') {
                $socketApp = new SocketClient();
            } else {
                throw new AppInvalidCliCommand('Invalid cli command expect: server or client');
            }
            $socketApp->run();
        } catch (
            SocketAcceptException|
            SocketBindException|
            SocketConnectException|
            SocketCreateException|
            SocketListenException $e)
        {
            echo 'App Socket error' . PHP_EOL;
        } catch (AppInvalidCliCommand $e) {
            echo $e->getMessage();
        }
    }
}
