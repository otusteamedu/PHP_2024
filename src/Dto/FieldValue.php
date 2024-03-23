<?php

declare(strict_types=1);

namespace RailMukhametshin\Hw\Dto;

use Spatie\DataTransferObject\DataTransferObject;

class FieldValue extends DataTransferObject
{
    public string $field;
    public string $value;
}
