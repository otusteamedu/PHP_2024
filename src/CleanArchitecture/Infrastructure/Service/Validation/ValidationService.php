<?php

declare(strict_types=1);

namespace AlexanderGladkov\CleanArchitecture\Infrastructure\Service\Validation;

use AlexanderGladkov\CleanArchitecture\Domain\Service\ValidationServiceInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class ValidationService implements ValidationServiceInterface
{
    private ViolationHelper $violationHelper;

    public function __construct(private ValidatorInterface $validator)
    {
        $this->violationHelper = new ViolationHelper();
    }

    /**
     * @param mixed $object
     * @return array
     */
    public function validate(mixed $object): array
    {
        $errors = $this->validator->validate($object);
        if (count($errors) > 0) {
            return $this->violationHelper->convertListToArray($errors);
        } else {
            return [];
        }
    }
}
