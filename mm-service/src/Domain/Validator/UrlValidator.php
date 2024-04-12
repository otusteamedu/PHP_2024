<?php
declare(strict_types=1);

namespace App\Domain\Validator;

use App\Domain\Exception\LogicException;

class UrlValidator
{
    const PATTERN = '^(https?:\/\/(?:www\.|(?!www))[a-zA-Z0-9][a-zA-Z0-9-]+[a-zA-Z0-9]\.[^\s]{2,}|'
                  . 'www\.[a-zA-Z0-9][a-zA-Z0-9-]+[a-zA-Z0-9]\.[^\s]{2,}|'
                  . 'https?:\/\/(?:www\.|(?!www))[a-zA-Z0-9]+\.[^\s]{2,}|'
                  . 'www\.[a-zA-Z0-9]+\.[^\s]{2,})$';

    public static function validate(string $url): void
    {
       $matchResult = preg_match(self::PATTERN, $url);

        if (0 === $matchResult) {
            throw new InvalidUrlException($url);
        }

        if (false === $matchResult) {
            throw new LogicException('Error while using regex');
        }
    }
}
