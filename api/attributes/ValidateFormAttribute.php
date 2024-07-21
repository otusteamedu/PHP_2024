<?php

declare(strict_types=1);

namespace api\attributes;

use Attribute;

#[Attribute]
class ValidateFormAttribute
{
    private int $formNumArgs;


    public function __construct(int $formNumArgs = 0, ?string $registerName = null)
    {
        $this->formNumArgs = $formNumArgs;
    }

    public function getFormNumArgs(): int
    {
        return $this->formNumArgs;
    }

}
