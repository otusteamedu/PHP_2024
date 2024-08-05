<?php

$config = parse_ini_file(__DIR__ . '/config.ini');

define("CLIENT_SOCKET_FILE_NAME", $config['client_socket_file_name'] ?? 'client');
define("SERVER_SOCKET_FILE_NAME", $config['server_socket_file_name'] ?? 'server');
define("SOCKET_RECEIVE_MAX_SIZE_B", (int) $config['socket_receive_max_size_b'] ?? 2048);
