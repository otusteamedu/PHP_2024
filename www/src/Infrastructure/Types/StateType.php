<?php

declare(strict_types=1);

namespace App\Infrastructure\Types;

use App\Domain\State\AbstractState;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\Type;

class StateType extends Type
{
    public function getSQLDeclaration(array $column, AbstractPlatform $platform): string
    {
        return 'integer';
    }

    public function convertToDatabaseValue(mixed $value, AbstractPlatform $platform): mixed
    {
        if ($value instanceof AbstractState) {
            return $value->toScalar();
        }
        return $value;
    }

    public function convertToPHPValue(mixed $value, AbstractPlatform $platform): mixed
    {
        return AbstractState::getStateFromScalar($value);
    }
}
