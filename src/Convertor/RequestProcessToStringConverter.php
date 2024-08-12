<?php

declare(strict_types=1);

namespace App\Convertor;

use App\Entity\RequestProcessEntity;

class RequestProcessToStringConverter
{
    public static function toString(RequestProcessEntity $entity): string
    {
        $array = [
            'id' => $entity->getId(),
            'status' => $entity->getUuid() === null ? 'processing' : 'processed',
            'uuid' => $entity->getUuid(),
        ];

        return (string) json_encode($array);
    }
}
