<?php

require_once('config.php');
require_once('class/App.class.php');
require_once('class/Socket.php');
require_once('class/Server.class.php');
require_once('class/Client.class.php');

try {
    $app = new \HW5\App();
    $app->run();
} catch (Exception $e) {
}
