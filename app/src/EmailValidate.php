<?php

declare(strict_types=1);

namespace SlavaMakhov\OtusVerificationEmailApp;

class EmailValidate
{
    /**
     * Метод валидации email
     *
     * @param string $email
     *
     * @return string
     */
    public function run(string $email): string
    {
        $checkFormat = $this->checkFormatEmail($email);

        if (!$checkFormat) {
            return 'ошибка в формате!';
        }

        $checkMx = $this->checkMXEmail($email);

        if (!$checkMx) {
            return 'ошибка в имени домена!';
        }

        return 'проверка успешна!';
    }

    /**
     * Метод проверяет email по регулярному вырожению
     * @param string $email
     *
     * @return bool
     */
    private function checkFormatEmail(string $email): bool
    {
        $regexEmail = '/^[_a-zа-я0-9-]+(\.[_a-zа-я0-9-]+)*@[a-zа-я0-9-]+(\.[a-zа-я0-9-]+)*(\.[a-zа-я]{2,3})$/u';

        return (bool)preg_match($regexEmail, $email);
    }

    /**
     * Метод проверяет DNS mx записи
     *
     * @param string $email
     *
     * @return bool
     */
    private function checkMXEmail(string $email): bool
    {
        return getmxrr(explode('@', $email)[1], $mx_records);
    }
}
