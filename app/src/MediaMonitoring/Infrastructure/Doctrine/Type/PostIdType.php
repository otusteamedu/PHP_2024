<?php

declare(strict_types=1);

namespace App\MediaMonitoring\Infrastructure\Doctrine\Type;

use App\MediaMonitoring\Domain\Entity\PostId;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\IntegerType;

class PostIdType extends IntegerType
{
    public const string POST_ID = 'post_id';

    public function convertToPHPValue($value, AbstractPlatform $platform): ?PostId
    {
        if ($value === null) {
            return null;
        }

        return new PostId($value);
    }

    public function convertToDatabaseValue($value, AbstractPlatform $platform): ?int
    {
        return $value?->value();
    }

    public function getName(): string
    {
        return self::POST_ID;
    }
}
