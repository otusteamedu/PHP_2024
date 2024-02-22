<?php

use Sfadeev\ChatApp\Server\Server;
use Sfadeev\ChatApp\Client\Client;
use Sfadeev\ChatApp\Socket\UnixSocket;

require dirname(__DIR__) . '/vendor/autoload.php';

const SOCKET_PATH = __DIR__ . '/var/my.sock';

$socket = new UnixSocket(SOCKET_PATH);

$stdin = fopen("php://stdin", "r");
$stdout = fopen("php://stdout", "w");

switch ($argv[1]) {
    case 'start-server':
        (new Server($socket, $stdout))->listen();
        break;
    case 'start-client':
        if (!file_exists(SOCKET_PATH)) {
            throw new RuntimeException(sprintf('Cокет %s не существует. Возможная причина - не запущен сервер.', SOCKET_PATH));
        }

        $client = new Client($socket);
        while (true) {
            if (!sendMessageInteractive($client, $stdin, $stdout)) {
                break 2;
            }
        }
}

fclose($stdin);
fclose($stdout);

/**
 * @param Client $client
 * @param resource $input
 * @param resource $output
 *
 * @return bool
 */
function sendMessageInteractive(Client $client, mixed $input, mixed $output): bool
{
    fwrite($output, '---' . PHP_EOL);
    fwrite($output, 'Введите сообщение.' . PHP_EOL);

    $data = trim(fgets($input));

    if ('' === $data) return false;

    $client->send($data);

    fwrite($output, 'Сообщение отправлено.' . PHP_EOL);

    return true;
}

