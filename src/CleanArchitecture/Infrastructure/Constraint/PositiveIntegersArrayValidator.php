<?php

declare(strict_types=1);

namespace AlexanderGladkov\CleanArchitecture\Infrastructure\Constraint;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;

class PositiveIntegersArrayValidator extends ConstraintValidator
{
    public function validate(mixed $value, Constraint $constraint)
    {
        if (!$constraint instanceof PositiveIntegersArray) {
            throw new UnexpectedTypeException($constraint, PositiveIntegersArray::class);
        }

        if ($this->isValueCorrect($value)) {
            return;
        }

        $this->context->buildViolation($constraint->message)->addViolation();
    }

    private function isValueCorrect(mixed $value): bool
    {
        if (!is_array($value)) {
            return false;
        }

        foreach ($value as $item) {
            if (!is_int($item)) {
                return false;
            }

            if ($item <= 0) {
                return false;
            }
        }

        return true;
    }
}
