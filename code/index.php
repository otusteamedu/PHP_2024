<?php

require 'vendor/autoload.php';


use IraYu\OtusHw4;
try {
    $request = new OtusHw4\HttpRequest($_POST + $_GET);
    (new OtusHw4\FrontController())
        ->setRequest($request)
        ->addCommand(new OtusHw4\RuleAlways(), new OtusHw4\CommandParenthesesCheck())
        ->resolve()
        ->print()
    ;
} catch (\Throwable $exception) {
    echo '500';
}
echo "<h1>Запрос обработал контейнер: " . $_SERVER['HOSTNAME'] . "</h1>";
