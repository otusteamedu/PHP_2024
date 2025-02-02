<?php


// Проверяем, был ли отправлен POST-запрос
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Проверяем, существует ли параметр 'string' в POST-запросе
    if (isset($_POST['string'])) {
        $string = $_POST['string'];

        // 1.1. Проверка на непустоту
        if (empty($string)) {
            http_response_code(400);
            echo "Ошибка: строка пуста.";
        } else {
            // 1.2. Проверка на корректность количества открытых и закрытых скобок
            $balance = 0;
            $length = strlen($string);

            for ($i = 0; $i < $length; $i++) {
                $char = $string[$i];
                if ($char == '(') {
                    $balance++;
                } elseif ($char == ')') {
                    $balance--;
                }

                // Если баланс стал отрицательным, значит закрывающих скобок больше
                if ($balance < 0) {
                    break;
                }
            }

            if ($balance == 0) {
                echo "Строка корректна: количество открытых и закрытых скобок совпадает.";
            } else {
                http_response_code(400);
                echo "Ошибка: количество открытых и закрытых скобок не совпадает.";
            }
        }
    } else {
        http_response_code(400);
        echo "Ошибка: параметр 'string' отсутствует в запросе.";
    }
} else {
    http_response_code(400);
    echo "Ошибка: запрос должен быть отправлен методом POST.";
}


//$json = file_get_contents('php://input');
//$data = json_decode($json, true);
//$string = $data['string'] ?? '';
//
//echo "Получили запрос: $string";
//
//if (!isset($data['string'])) {
//    http_response_code(400);
//    exit;
//}


?>