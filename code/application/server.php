<?php
declare(strict_types=1);

set_time_limit(0);
ob_implicit_flush();

if (($sock = socket_create(AF_UNIX, SOCK_STREAM, 0)) === false) {
    echo "Не удалось выполнить socket_create(): причина: " . socket_strerror(socket_last_error()) . "\n";
} else echo "Сокет создан\n";
$path = '/tmp/phpsocket/socket.sock';
if (file_exists($path)) unlink($path);
socket_bind($sock,$path);

if (socket_listen($sock) === false) {
    echo "Не удалось выполнить socket_listen(): причина: " . socket_strerror(socket_last_error($sock)) . "\n";
}

do {
    if (($msgsock = socket_accept($sock)) === false) {
        echo "Не удалось выполнить socket_accept(): причина: " . socket_strerror(socket_last_error($sock)) . "\n";
        break;
    }
    /* Отправляем инструкции. */
    $msg = "\nДобро пожаловать на тестовый сервер PHP. \n" .
        "Чтобы отключиться, наберите 'выход'. Чтобы выключить сервер, наберите 'выключение'.\n";
    socket_write($msgsock, $msg, strlen($msg));

    while (true) {
        if (false === ($buf = socket_read($msgsock, 2048))) {
            echo "Не удалось выполнить socket_read(): причина: " . socket_strerror(socket_last_error($msgsock)) . "\n";
            break 2;
        }

        if (!$buf = trim($buf)) {
            continue;
        }

        if ($buf == 'exit') {
            $close = "Socket connection closed.";
            echo $close;
            break;
        }

        $talkback = "PHP: Вы сказали '$buf'.\n";
        socket_write($msgsock, $talkback, strlen($talkback));
        echo "$buf\n";
    }
    socket_close($msgsock);
} while (true);

socket_close($sock);
unlink($path);