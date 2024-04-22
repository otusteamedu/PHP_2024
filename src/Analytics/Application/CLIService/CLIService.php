<?php

declare(strict_types=1);

namespace AlexanderGladkov\Analytics\Application\CLIService;

use AlexanderGladkov\Analytics\Application\Command;
use AlexanderGladkov\Analytics\Application\Arg\AddArg;
use AlexanderGladkov\Analytics\Application\Arg\GetArg;
use Docopt;
use Docopt\Response;
use InvalidArgumentException;

class CLIService
{
    public function getInput(): Input
    {
        $response = Docopt::handle($this->getInterfaceDescription());
        $command = $this->getCommandFromResponse($response);
        $args = $this->getArgsFromResponse($response, $command);
        return new Input($command, $args);
    }

    private function getCommandFromResponse(Response $response): Command
    {
        $possibleCommands = Command::values();
        foreach ($response->args as $arg => $value) {
            if (in_array($arg, $possibleCommands) && $value === true) {
                return Command::from($arg);
            }
        }

        throw new InvalidArgumentException('Возможные команды: ' . implode(', ', $possibleCommands) . '.');
    }

    private function getArgsFromResponse(Response $response, Command $command): array
    {
        return match ($command) {
            Command::Add => $this->extractArgs($response, AddArg::values()),
            Command::Get => $this->extractArgs($response, GetArg::values()),
            Command::FillTestData, Command::DeleteAll => [],
        };
    }

    private function extractArgs(Response $response, array $possibleArgNames): array
    {
        $resultArgs = [];
        foreach ($response->args as $arg => $value) {
            $position = mb_strpos($arg, '--');
            if ($position === false || $position !== 0) {
                continue;
            }

            if ($value === null || $value === false) {
                continue;
            }

            $argName = mb_substr($arg, 2);
            if (!in_array($argName, $possibleArgNames)) {
                continue;
            }

            $resultArgs[$argName] = $value;
        }

        return $resultArgs;
    }

    private function getInterfaceDescription(): string
    {
        return <<<DOC
Analytics.

Usage:
    app.php add --priority=<priority> --value=<value> [--condition=<condition>]...
    app.php get [--condition=<condition>]...
    app.php delete-all
    app.php fill-test-data
    app.php (-h | --help)

Options:
    -h --help                     Show this screen.
    --priority=<priority>         Event priority.
    --value="<value>"             Event value.
    --condition="<condition>"     Condition in format: name=value

Examples:
    app.php add --priority=1000 --value="event" --condition="param1=1" --condition="param2=2"
    app.php get --condition="param1=1" --condition="param2=2"
    app.php delete-all
    app.php fill-test-data
DOC;
    }
}
