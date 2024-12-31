<?php
try {
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['string'])) {
        if (!empty($_POST['string'])) {
            $arStr = mb_str_split($_POST['string']);

            $stack = [];
            foreach ($arStr as $symbol) {
                if ($symbol === '(') {
                    $stack[] = $symbol;
                } elseif ($symbol === ')') {
                    if (empty($stack)) {
                        throw new Exception('Строка с некорректным соответствием скобок!', 400);
                    }

                    array_pop($stack);
                }
            }

            if (empty($stack)) {
                echo 'Все хорошо! Все скобки на месте!' . PHP_EOL;
            } else {
                throw new Exception('Строка с некорректным соответствием скобок!', 400);
            }

        } else {
            throw new Exception('Параметр string не может быть пустым', 400);
        }
    }
} catch (Exception $exception) {
    http_response_code($exception->getCode());
    echo $exception->getMessage() . PHP_EOL;
} finally {
    echo "Запрос обработал контейнер: " . $_SERVER['HOSTNAME'];
}