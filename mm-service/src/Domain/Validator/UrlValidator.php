<?php

declare(strict_types=1);

namespace App\Domain\Validator;

use App\Domain\Validator\Exception\InvalidUrlException;
use App\Domain\Validator\Exception\InvalidUrlFormatException;
use App\Domain\Validator\Exception\InvalidUrlLengthException;

class UrlValidator
{
    public const MAX_LENGTH = 2048;

    /**
     * @throws InvalidUrlException
     */
    public static function validate(string $url): void
    {
        self::validateLength($url);
        self::validateFormat($url);
    }

    /**
     * @throws InvalidUrlLengthException
     */
    private static function validateLength(string $url): void
    {
        $length = mb_strlen($url);

        if ($length > self::MAX_LENGTH) {
            throw new InvalidUrlLengthException($url, self::MAX_LENGTH);
        }
    }

    /**
     * @throws InvalidUrlFormatException
     */
    private static function validateFormat(string $url): void
    {
        if (false === filter_var($url, FILTER_VALIDATE_URL)) {
            throw new InvalidUrlFormatException($url);
        }
    }
}
