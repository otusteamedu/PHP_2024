<?php

declare(strict_types=1);

namespace AlexanderPogorelov\ElasticSearch\Validator;

use AlexanderPogorelov\ElasticSearch\Exception\ValidatorException;

class PromptValidator
{
    /**
     * @throws ValidatorException
     */
    public function validate(array $searchDto): void
    {
        if ($this->isEmpty($searchDto['query'])) {
            throw new ValidatorException('Query cannot be empty');
        }

        if ($this->isWrongNumeric($searchDto['minPrice'])) {
            throw new ValidatorException('Minimum price must be numeric');
        }

        if ($this->isWrongNumeric($searchDto['maxPrice'])) {
            throw new ValidatorException('Maximum price must be numeric');
        }

        if ($this->isWrongNumeric($searchDto['quantity'])) {
            throw new ValidatorException('Minimum quantity must be numeric');
        }
    }

    private function isEmpty(string $value): bool
    {
        return '' === $value;
    }

    private function isWrongNumeric(string $value): bool
    {
        return !$this->isEmpty($value) && !is_numeric($value);
    }
}
