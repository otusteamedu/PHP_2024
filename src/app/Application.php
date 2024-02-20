<?php

declare(strict_types=1);

namespace AlexanderGladkov\App;

use Exception;

class Application
{
    /**
     * @return void
     */
    public function run(): void
    {
        try {
            $this->checkRequest();
        } catch (Exception $e) {
            echo $e->getMessage();
            return;
        }

        $string = $_POST['string'];
        try {
            (new Validation())->validateBrackets($string);
            http_response_code(200);
            echo 'Строка корректна!';
        } catch (Exception $e) {
            http_response_code(400);
            echo $e->getMessage();
        }
    }

    /**
     * @throws Exception
     */
    private function checkRequest()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(405);
            header('Allow: POST');
            throw new Exception('Неверный метод запроса!');
        }

        $string = $_POST['string'] ?? null;
        if ($string === null) {
            http_response_code(400);
            throw new Exception('В запросе должен быть параметр "string"!');
        }
    }
}
