<?php

namespace App\Infrastructure\Validator;

use AllowDynamicProperties;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

#[AllowDynamicProperties]
class DigitalArrayValidator extends ConstraintValidator
{
    /**
     * @param array $value
     * @param Constraint $constraint
     * @return void
     */
    public function validate($value, Constraint $constraint): void
    {
        /** @var DigitalArray $constraint */

        if (null === $value || '' === $value) {
            return;
        }

        $notNumberList = '';
        foreach ($value as $number) {
            if (!is_int($number)) {
                $notNumberList .= "'" . $number . "', ";
            }
        }

        if (empty($notNumberList)) {
            return;
        }

        $value = mb_substr($notNumberList, 0, -2);

        $this->context->buildViolation($constraint->message)
            ->setParameter('{{ value }}', $value)
            ->addViolation();
    }
}
