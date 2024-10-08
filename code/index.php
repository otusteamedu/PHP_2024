<?php

use Naimushina\ChannelManager\App;

require_once __DIR__ . '/vendor/autoload.php';


$app = new App();

try {
    echo $app->run();
    /*foreach ($app->run() as $message) {

    };*/
} catch (Exception $e) {
    echo $e->getMessage();
}
