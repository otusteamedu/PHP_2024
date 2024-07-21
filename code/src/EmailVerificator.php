<?php

namespace Naimushina\Verificator;

class EmailVerificator
{
    /**
     * @var string Регулярное выражение для корректного формата адреса электронной почты(как латиницей, так и кириллицей)
     */
    const REG_EX_MASK = '/^((([0-9A-Za-z]{1}[-0-9A-z\.]{1,}[0-9A-Za-z]{1})|([0-9А-Яа-я]{1}[-0-9А-я\.]{1,}[0-9А-Яа-я]{1}))@([-A-Za-z]{1,}\.){1,2}[-A-Za-z]{2,})$/u';

    /**
     * Валидация email по регулярному выражению
     * @param string $email
     * @return bool
     */
    public function checkByRegEx(string $email): bool
    {
        $result = preg_match(self::REG_EX_MASK, trim($email));
        return !!$result;
    }

    /**
     * Проверке DNS mx записи
     * @param string $email
     * @return bool
     */
    public function checkByDns(string $email): bool
    {
        $emailBreakDown = explode("@",$email);
        $domain = array_pop($emailBreakDown);
        return  $domain && checkdnsrr($domain);
    }
}
