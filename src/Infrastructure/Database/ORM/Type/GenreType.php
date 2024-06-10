<?php

declare(strict_types=1);

namespace App\Infrastructure\Database\ORM\Type;

use App\Domain\ValueObject\Genre;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\Type;

class GenreType extends Type
{
    public const EMAIL = 'genre';

    public function getSQLDeclaration(array $column, AbstractPlatform $platform): string
    {
        return $platform->getStringTypeDeclarationSQL([
            'length' => 60,
        ]);
    }

    public function convertToPHPValue($value, AbstractPlatform $platform): ?Genre
    {
        return $value !== null ? new Genre($value) : null;
    }

    public function convertToDatabaseValue($value, AbstractPlatform $platform): ?string
    {
        return $value instanceof Genre ? $value->getValue() : $value;
    }

    public function getName(): string
    {
        return self::EMAIL;
    }
}
