<?php

namespace Ekonyaeva\Otus\Interfaces;
interface EmailValidatorInterface
{
    public function validate(array $emails): array;
}