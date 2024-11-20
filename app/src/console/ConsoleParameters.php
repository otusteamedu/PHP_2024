<?php

declare(strict_types=1);

namespace Dsergei\Hw12\console;

class ConsoleParameters
{
    public array $params;

    public string $command;

    const COMMANDS = [
        'clear',
        'add',
        'get'
    ];

    public function __construct()
    {
        $options = getopt('', ['params:', 'command:', ':priority']);

        if (empty($options['command'])) {
            throw new \DomainException('Option command is required');
        }

        $options['command'] = (string)$options['command'];

        if($options['command'] !== 'clear') {
            if (empty($options['params'])) {
                throw new \DomainException('Option params is required');
            }

            $options['params'] = json_decode($options['params'], true);

            if (!is_array($options)) {
                throw new \DomainException('Options params is not valid json');
            }
        }


        if(!in_array($options['command'], self::COMMANDS, true)) {
            throw new \DomainException('This command is disallow');
        }

        $this->params = $options['params'] ?? [];
        $this->command = $options['command'];
    }
}
