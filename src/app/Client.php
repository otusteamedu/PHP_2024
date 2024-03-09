<?php

declare(strict_types=1);

namespace ChatOtus\App;

use ErrorException;

class Client implements SocketChat
{
    /**
     * @param string $socketPath
     * @throws ErrorException
     */
    public function run(string $socketPath)
    {
        $client = stream_socket_client("unix://$socketPath", $errno, $errstr);
        if (!$client) {
            throw new ErrorException($errstr, $errno);
        }

        echo "Connected to the server. Type your message:\n";

        while ($message = fgets(STDIN)) {
            $client = stream_socket_client("unix://$socketPath", $errno, $errstr);
            if (!$client) {
                throw new ErrorException($errstr, $errno);
            }
            fwrite($client, $message);
            $response = fread($client, 1024);
            echo "Server response: $response\n";
        }

        fclose($client);
    }
}