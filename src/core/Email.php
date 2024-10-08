<?php

namespace Ali;

class Email
{
    public static array $emails = [
        'example@example.com',
        'invalid-email',
        'test@invalid_domain.com',
        'user@gmail.com',
        'user@nonexistentdomain.xyz',
    ];

    public static function getEmails(): array
    {
        return self::$emails;
    }
}