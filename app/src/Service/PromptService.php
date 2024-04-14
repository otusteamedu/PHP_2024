<?php

declare(strict_types=1);

namespace AlexanderPogorelov\Redis\Service;

use AlexanderPogorelov\Redis\Config;
use AlexanderPogorelov\Redis\Validator\PromptValidator;

readonly class PromptService
{
    public function __construct(private PromptValidator $validator, private Config $config)
    {
    }

    public function readInput(): array
    {
        $searchData = [];

        foreach ($this->config->getParameterNames() as $parameterName) {
            $inputValue = (string) readline(sprintf('Введите значение параметра %s: ', $parameterName));

            if ('' === $inputValue) {
                continue;
            }

            $searchData[$parameterName] = $inputValue;
        }

        $this->validator->validate($searchData);

        return array_map('intval', $searchData);
    }
}
