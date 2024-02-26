<?php

namespace Dsergei\Hw6;

interface IValidator
{
    public function validate(string $email): void;

    public function log(): \Generator;
}
