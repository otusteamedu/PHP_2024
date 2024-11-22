<?php

declare(strict_types=1);

require __DIR__ . '/vendor/autoload.php';

$controller = new \IgorKachko\OtusComposerApp\Infrastructure\StringController();
if(isset($_POST["string"]))
    $controller->run($_POST["string"]);