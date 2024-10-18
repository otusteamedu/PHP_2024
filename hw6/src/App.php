<?php

class App
{
    public function run()
    {
        global $argv;

        if (!isset($argv[1])) {
            throw new Exception("No role specified.");
        }

        $role = $argv[1];

        $config = parse_ini_file(__DIR__ . '/../config.ini', true);

        switch ($role) {
            case 'server':
                $server = new Server($config['socket']['socket_path']);
                $server->run();
                break;

            case 'client':
                $client = new Client($config['socket']['socket_path']);
                $client->run();
                break;

            default:
                throw new Exception("Invalid role specified.");
        }
    }
}
