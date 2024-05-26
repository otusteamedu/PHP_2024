<?php

declare(strict_types=1);

namespace AlexanderGladkov\CleanArchitecture\Domain\Service;

interface ValidationServiceInterface
{
    /**
     * @param mixed $object
     */
    public function validate(mixed $object): array;
}