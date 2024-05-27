<?php

declare(strict_types=1);

namespace AlexanderGladkov\CleanArchitecture\Domain\Service;

interface ValidationServiceInterface
{
    /**
     * @param mixed $object
     * @return array
     */
    public function validate(mixed $object): array;
}
