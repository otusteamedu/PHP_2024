<?php

declare(strict_types=1);

namespace AlexanderGladkov\CleanArchitecture\Infrastructure\Service\Validation;

use Symfony\Component\Validator\ConstraintViolationListInterface;

class ViolationHelper
{
    public function convertListToArray(ConstraintViolationListInterface $violations): array
    {
        $errors = [];
        foreach ($violations as $constraint) {
            $property = $constraint->getPropertyPath();
            $errors[$property][] = $constraint->getMessage();
        }

        return $errors;
    }
}
