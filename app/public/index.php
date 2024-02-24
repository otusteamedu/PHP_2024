<?php
//Подключение файлов
require_once $_SERVER['DOCUMENT_ROOT'] . '/../source/Config/Preload.php';
(new \Pavelsergeevich\Hw6\Config\Preload())->run();

$app = new \Pavelsergeevich\Hw6\App;
$result = $app->run();