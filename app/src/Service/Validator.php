<?php

declare(strict_types=1);

namespace App\Service;

use App\Dto\TaskRequestDto;
use App\Entity\Task;
use Symfony\Component\Validator\ConstraintViolationListInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class Validator
{
    public function __construct(
        private readonly ValidatorInterface $validator,
    ) {
    }

    public function validate(mixed $dto): array
    {
        $violations = $this->validator->validate($dto);

        if (0 === count($violations)) {
            return [];
        }

        return $this->fetchErrors($violations);
    }

    private function fetchErrors(ConstraintViolationListInterface $violations): array
    {
        $errors = [];

        foreach ($violations as $violation) {
            $errors[$violation->getPropertyPath()] = $violation->getMessage();
        }

        return $errors;
    }
}
