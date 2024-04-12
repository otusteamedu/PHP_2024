<?php
declare(strict_types=1);

namespace App\Infrastructure\Doctrine\Type;

use App\Domain\ValueObject\Url;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\ConversionException;
use Doctrine\DBAL\Types\Type;
use Throwable;

class UrlType extends Type
{
    public const NAME = 'url';

    public function getSQLDeclaration(array $column, AbstractPlatform $platform): string
    {
        return $platform->getClobTypeDeclarationSQL($column);
    }

    public function convertToPHPValue($value, AbstractPlatform $platform)
    {
        if ($value instanceof Url || null === $value) {
            return $value;
        }

        if (!is_string($value)) {
            throw ConversionException::conversionFailedInvalidType(
                $value, $this->getName(),
                ['null', 'string', Url::class]
            );
        }

        try {
            return new Url($value);
        } catch (Throwable $e) {
            throw ConversionException::conversionFailed($value, $this->getName(), $e);
        }
    }

    public function getName(): string
    {
        return self::NAME;
    }
}
