<?php

namespace Controller;

use Service\SessionManager;
use Service\Validator;

class RequestHandler
{

    private $sessionManager;

    public function __construct()
    {
        $this->sessionManager = new SessionManager();
    }

    public function handle(): string
    {
        header('Content-Type: text/plain');

        $hostname = gethostname();
        $response = "Имя хоста: " . $hostname . PHP_EOL;

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $this->sessionManager->setMessage('Обработан POST-запрос.');

            if (isset($_POST['string']) && !empty(trim($_POST['string']))) {
                $string = trim($_POST['string']);
                $validator = new Validator();

                if ($validator->isValidString($string)) {
                    http_response_code(200);

                    $response .= 'Строка действительна.' . PHP_EOL;
                } else {
                    http_response_code(400);

                    $response .= 'Строка недействительна.' . PHP_EOL;
                }
            } else {
                http_response_code(400);

                $response .= 'Строковый параметр отсутствует или пуст.' . PHP_EOL;
            }
        } else {
            http_response_code(405);

            $response .= 'Метод не разрешен.' . PHP_EOL;
        }

        $this->sessionManager->handleSetMessage();
        $sessionResponse = $this->sessionManager->getFormattedMessage();
        $response .= $sessionResponse;

        return $response;
    }

}
