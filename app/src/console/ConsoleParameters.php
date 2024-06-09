<?php

declare(strict_types=1);

namespace Dsergei\Hw12\console;

readonly class ConsoleParameters
{
    public array $params;

    public function __construct()
    {
        $options = getopt('', ['params:']);
        if (empty($options['params'])) {
            throw new \DomainException('Option params is required');
        }

        $options['params'] = json_decode($options['params'], true);

        if (!is_array($options)) {
            throw new \DomainException('Options params is not valid json');
        }

        $this->params = $options['params'];
    }
}
