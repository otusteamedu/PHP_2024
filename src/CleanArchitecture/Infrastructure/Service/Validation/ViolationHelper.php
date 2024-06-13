<?php

declare(strict_types=1);

namespace AlexanderGladkov\CleanArchitecture\Infrastructure\Service\Validation;

use Symfony\Component\Validator\ConstraintViolationInterface;
use Symfony\Component\Validator\ConstraintViolationListInterface;

class ViolationHelper
{
    public function convertListToArray(ConstraintViolationListInterface $violations): array
    {
        $errors = [];
        foreach ($violations as $constraint) {
            /**
             * @var ConstraintViolationInterface $constraint
             */
            $keys = $this->getKeysFromPropertyPath($constraint->getPropertyPath());

            $errorsLink = &$errors;
            foreach ($keys as $key) {
                if (!isset($errorsLink[$key])) {
                    $errorsLink[$key] = [];
                }

                $errorsLink = &$errorsLink[$key];
            }

            $errorsLink[] = $constraint->getMessage();
        }

        return $errors;
    }

    private function getKeysFromPropertyPath(string $propertyPath): array
    {
        $propertyPath = preg_replace('/\[(.*?)\]/', '.$1', $propertyPath);
        $keys = explode('.', $propertyPath);
        // Удаление ключа 'value' для value object.
        $keysCount = count($keys);
        if ($keysCount > 1 && $keys[$keysCount - 1] === 'value') {
            array_pop($keys);
        }

        return $keys;
    }
}
