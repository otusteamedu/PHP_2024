<?php

namespace hw6;

interface ValidatorInterface
{
    public function validate(string $string): bool;
}
