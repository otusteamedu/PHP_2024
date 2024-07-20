<?php

return [
    'socket_file' => [
        getenv('SOCKET_FILE'),
        '/code/src/socket/socket.sock'
    ],
    'socket_max_connection' => [
        getenv('SOCKET_MAX_CONNECTION'),
        5
    ],
    'socket_length' => [
        getenv('SOCKET_LENGTH'),
        2086
    ],
];
