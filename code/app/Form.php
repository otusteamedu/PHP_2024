<?php

declare(strict_types=1);

namespace Afilippov\Hw4\app;

use Exception;

readonly class Form
{
    public string $inputString;

    /**
     * @throws Exception
     */
    public function __construct(array $postParams)
    {
        if (empty($postParams['string'])) {
            throw new Exception('Параметр `string` не передан или пустой.');
        }
        if (!is_string($postParams['string'])) {
            throw new Exception('Параметр `string` не строка.');
        }
        $this->inputString = $postParams['string'];
    }
}
