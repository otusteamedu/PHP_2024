<?php

declare(strict_types=1);

namespace App;

class App
{
    public function run(): void
    {
        $statusResponseService = new StatusResponseService();
        $printerService = new PrinterService();

        $isPost = RequestValidator::isPost();
        if ($isPost) {
            $string = $_POST['string'] ?? null;
            $isNotEmpty = StringValidator::isNotEmpty($string);
            if ($isNotEmpty) {
                $isValid = StringValidator::validateString($string);
                if ($isValid) {
                    $statusResponseService->setResponse200();
                    $printerService->print("Все хорошо: строка корректна.");
                    return;
                }

                $statusResponseService->setResponse400();
                $printerService->print("Ошибка: некорректный формат строки");
                return;
            }

            $statusResponseService->setResponse400();
            $printerService->print("Ошибка: строка пуста");
            return;
        }

        $statusResponseService->setResponse400();
        $printerService->print("Method Not Allowed");
    }
}
