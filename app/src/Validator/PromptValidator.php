<?php

declare(strict_types=1);

namespace AlexanderPogorelov\Redis\Validator;

use AlexanderPogorelov\Redis\Exception\ValidatorException;

class PromptValidator
{
    /**
     * @throws ValidatorException
     */
    public function validate(array $searchData): void
    {
        if (0 === \count($searchData)) {
            throw new ValidatorException('Missing search data');
        }

        foreach ($searchData as $name => $value) {
            if (!is_numeric($value)) {
                throw new ValidatorException(sprintf('Only numeric values allowed for %s ', $name));
            }
        }
    }
}
