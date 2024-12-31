<?php

use Den\Hw5\App;
use Den\Hw5\Http\Request;

require '../vendor/autoload.php';

try {
    $request = Request::createFromGlobals();
    $app = new App($request);
    echo $app->run();
} catch (Exception $exception) {
    http_response_code($exception->getCode());
    echo $exception->getMessage() . ' <a href="/">Попробуйте еще раз</a>' . PHP_EOL;
} finally {
    echo '<br><br>  Запрос обработал контейнер: ' . $_SERVER['HOSTNAME'];
}
