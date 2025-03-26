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

    /**
     * Проверяет список строк или отдельный email на наличие валидных email.
     *
     * @template T of array<string>|string
     * @param T $emails Список строк или одиночный email.
     */
    private function validateEmails(array|string $emails): array
    {
        $results = []; // Сохраняем результаты валидации

        // Если передан одиночный email — преобразуем в массив
        $emails = is_array($emails) ? $emails : [$emails];

        foreach ($emails as $email) {
            // Базовая проверка по регулярному выражению
            $isValidRegex = filter_var($email, FILTER_VALIDATE_EMAIL) !== false;

            // Проверка DNS-записи MX, если прошла базовая проверка
            $hasMxRecord = $isValidRegex && $this->checkDnsMxRecord($email);

            $results[$email] = [
                'valid_regex' => $isValidRegex,
                'has_mx_record' => $hasMxRecord,
                'is_valid' => $isValidRegex && $hasMxRecord,
            ];
        }

        return $results;
    }

    /**
     * Проверяет наличие MX-записи для email.
     *
     * @param string $email Email для проверки.
     * @return bool Возвращает true, если MX-запись найдена, иначе false.
     */
    private function checkDnsMxRecord(string $email): bool
    {
        $domain = substr(strrchr($email, '@'), 1); // Извлекаем домен из email

        return $domain && checkdnsrr($domain); // Проверяем MX-запись
    }

    public function runHw5(): void
    {
        // Пример использования
        $emailsToCheck = [
            'validemail@example.com',
            'invalidemail.com',
            'no-domain@invalid-domain',
            'example@google.com',
        ];

        $results = $this->validateEmails($emailsToCheck);

        echo "Результаты проверки:\n";
        echo '<br>';
        foreach ($results as $email => $result) {
            echo "Email: $email\n";
            echo '<br>';
            echo "  - Валидный по Regex: " . ($result['valid_regex'] ? 'Да' : 'Нет') . "\n";
            echo '<br>';
            echo "  - MX-запись найдена: " . ($result['has_mx_record'] ? 'Да' : 'Нет') . "\n";
            echo '<br>';
            echo "  - Итоговая валидация: " . ($result['is_valid'] ? 'Успешно' : 'Неудачно') . "\n\n";
            echo '<br>';
        }
    }
}
