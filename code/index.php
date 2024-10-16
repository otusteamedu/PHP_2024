<?php


use Naimushina\ElasticSearch\App;

require_once __DIR__ . '/vendor/autoload.php';


$app = new App();

try {
    echo $app->run();
} catch (Exception $e) {
    echo $e->getMessage();
}
