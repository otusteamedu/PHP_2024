<?php

declare(strict_types=1);

namespace Alogachev\Homework;

class EmailValidator
{
    public function validate(array $emailList): array
    {
        return array_map(
            function (string $email) {
                $explodedEmail = explode('@', $email);
                return $this->isValidByRegex($email) && isset($explodedEmail[1]) && $this->isValidByDnsMx($explodedEmail[1])
                    ? "Валидный email: $email <br>"
                    : "Невалидный email: $email <br>";
            },
            $emailList
        );
    }

    private function isValidByRegex(string $email): bool
    {
        return (bool)preg_match('/(?:[a-z0-9!#$%&\'*+\/=?^_`{|}~-]+(?:\.[a-z0-9!#$%&\'*+\/=?^_`{|}~-]+)*|"(?:[\x01-\x08\x0b\x0c\x0e-\x1f\x21\x23-\x5b\x5d-\x7f]|\\\\[\x01-\x09\x0b\x0c\x0e-\x7f])*")@(?:(?:[a-z0-9](?:[a-z0-9-]*[a-z0-9])?\.)+[a-z0-9](?:[a-z0-9-]*[a-z0-9])?|\[(?:(?:(2(5[0-5]|[0-4][0-9])|1[0-9][0-9]|[1-9]?[0-9]))\.){3}(?:(2(5[0-5]|[0-4][0-9])|1[0-9][0-9]|[1-9]?[0-9])|[a-z0-9-]*[a-z0-9]:(?:[\x01-\x08\x0b\x0c\x0e-\x1f\x21-\x5a\x53-\x7f]|\\\\[\x01-\x09\x0b\x0c\x0e-\x7f])+)\])/u', $email);
    }

    private function isValidByDnsMx(string $domain): bool
    {
        return checkdnsrr($domain);
    }
}
