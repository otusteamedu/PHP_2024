<?php

declare(strict_types=1);


namespace Main\Validators;


interface Validator {
    public function validate(): bool;
    public function getErrorMessage(): string;
}