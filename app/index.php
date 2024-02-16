<?php require_once $_SERVER['DOCUMENT_ROOT'] . '/src/preload.php';

use \Pavelsergeevich\Hw4\Stapler;

try {
    if (!($_POST['string'])) {
        throw new InvalidArgumentException('Не передан POST параметр string');
    }
    $staple = new Stapler($_POST['string']);
    $validationResult = $staple->isValid();
    if (!$validationResult['isValid']) {
        throw new Exception($validationResult['message']);
    }
    echo $validationResult['message'];
} catch (\Throwable $exception) {
    http_response_code(400);
    echo $exception->getMessage();
} finally {
    echo "<br>    Запрос обработал контейнер: " . $_SERVER['HOSTNAME'];
}