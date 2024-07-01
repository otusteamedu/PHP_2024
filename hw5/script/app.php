<?php

require_once('class/App.class.php');
require_once('class/Server.class.php');
require_once('class/Client.class.php');
try {
    $app = new \script\class\App();
    $app->run();
} catch (Exception $e) {
}