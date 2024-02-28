<?php
spl_autoload_register(function ($class) {
    $class = str_replace('\\', '/', $class);
    include $class . '.php';
});

$validatePostData =  new \src\Classes\Validate\PostData($_POST);
try {
    $validationResult = $validatePostData->validate();
    echo 'Всё хорошо';
} catch (Exception $e) {
    header("HTTP/1.1 400 Bad Request");
    echo 'Всё плохо';
    echo $e->getMessage();

}

var_dump($_POST);
echo "Привет, Otus!<br>".date("Y-m-d H:i:s")."<br><br>";

echo "Запрос обработал контейнер: " . $_SERVER['HOSTNAME'];

