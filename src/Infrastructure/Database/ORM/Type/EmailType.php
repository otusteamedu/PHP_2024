<?php

declare(strict_types=1);

namespace App\Infrastructure\Database\ORM\Type;

use App\Domain\ValueObject\Email;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\Type;

class EmailType extends Type
{
    public const EMAIL = 'email';

    public function getSQLDeclaration(array $column, AbstractPlatform $platform): string
    {
        return $platform->getStringTypeDeclarationSQL([
            'length' => 60,
        ]);
    }

    public function convertToPHPValue($value, AbstractPlatform $platform): ?Email
    {
        return $value !== null ? new Email($value) : null;
    }

    public function convertToDatabaseValue($value, AbstractPlatform $platform): ?string
    {
        return $value instanceof Email ? $value->getValue() : null;
    }

    public function getName(): string
    {
        return self::EMAIL;
    }
}
