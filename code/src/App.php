<?php

declare(strict_types=1);

namespace App;

class App
{
    /**
     * Проверяет список строк или отдельный email на наличие валидных email.
     *
     * @template T of array<string>|string
     * @param T $emails Список строк или одиночный email.
     */
    public function validateEmails(array|string $emails): array
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
}
