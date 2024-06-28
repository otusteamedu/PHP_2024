<?php

use Evgenyart\EmailValidator\App;

require_once(__DIR__ . '/vendor/autoload.php');

try {
    $app = new App();
    $app->run();    //интерактивный режим
    #$app->process($list);  //проверить список
} catch (Exception $e) {
    echo "Ошибка: ";
    echo $e->getMessage();
    echo PHP_EOL;
}
