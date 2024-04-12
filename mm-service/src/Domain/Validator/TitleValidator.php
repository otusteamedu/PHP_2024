<?php
declare(strict_types=1);

namespace App\Domain\Validator;

use App\Domain\Exception\LogicException;
use App\Domain\Validator\Exception\InvalidTitleException;
use App\Domain\Validator\Exception\InvalidTitleFormatException;
use App\Domain\Validator\Exception\InvalidTitleLengthException;

class TitleValidator
{
    public const string PATTERN = '/^[ЁА-яёA-Za-z0-9\s\-_,.;:()]+$/';
    public const int MIN_LENGTH = 2;
    public const int MAX_LENGTH = 255;

    /**
     * @param string $title
     * @return void
     *
     * @throws InvalidTitleException
     */
    public static function validate(string $title): void
    {
        self::validateLength($title);
        self::validateFormat($title);
    }

    /**
     * @param string $title
     * @return void
     *
     * @throws InvalidTitleLengthException
     */
    private static function validateLength(string $title): void
    {
        $length = mb_strlen($title);

        if ($length < self::MIN_LENGTH || $length > self::MAX_LENGTH) {
            throw new InvalidTitleLengthException($title, self::MIN_LENGTH, self::MAX_LENGTH);
        }
    }

    /**
     * @param string $title
     * @return void
     *
     * @throws InvalidTitleFormatException
     */
    private static function validateFormat(string $title): void
    {
        $matchResult = preg_match(self::PATTERN, $title);

        if (0 === $matchResult) {
            throw new InvalidTitleFormatException($title);
        }

        if (false === $matchResult) {
            throw new LogicException('Error while using regex');
        }
    }
}
