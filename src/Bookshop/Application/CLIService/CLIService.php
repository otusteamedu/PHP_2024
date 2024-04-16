<?php

declare(strict_types=1);

namespace AlexanderGladkov\Bookshop\Application\CLIService;

use AlexanderGladkov\Bookshop\Application\Command;
use AlexanderGladkov\Bookshop\Application\SearchArg;
use Docopt;
use Docopt\Response;
use InvalidArgumentException;

class CLIService
{
    public function getInput(): Input
    {
        $response = Docopt::handle($this->getInterfaceDescription());
        $command = $this->getCommandFromResponse($response);
        $args = match ($command) {
            Command::CreateIndex => [],
            Command::Search => $this->getSearchArgsFromResponse($response)
        };

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

    private function getSearchArgsFromResponse(Response $response): array
    {
        $possibleArgs = SearchArg::values();
        $searchArgs = [];
        foreach ($response->args as $arg => $value) {
            $position = mb_strpos($arg, '--');
            if ($position === false || $position !== 0) {
                continue;
            }

            if ($value === null || $value === false) {
                continue;
            }

            $argName = mb_substr($arg, 2);
            if (!in_array($argName, $possibleArgs)) {
                continue;
            }

            $searchArgs[$argName] = $value;
        }

        return $searchArgs;
    }

    private function getInterfaceDescription(): string
    {
        return <<<DOC
Bookshop.

Usage:
  app.php create-index
  app.php search
      [--title="<title>"] 
      [--category="<category>"] 
      [--priceFrom=<priceFrom>] 
      [--priceTo=<priceTo>] 
      [--shop="<shop>"] 
      [--stock=<stock>] 
      [--page=<page>] 
      [--pageSize=<pageSize>]
  app.php (-h | --help)  

Options:
  -h --help                 Show this screen.
  --title="<title>"         Book title.
  --category="<category>"   Book category.
  --priceFrom=<priceFrom>   Min book price. 
  --priceTo=<priceTo>       Max book price.
  --shop="<shop>"           Shop address.
  --stock=<stock>           Min book quantity in shop.
  --page=<page>             Page number [default: 1].
  --pageSize=<pageSize>     Page size [default: 10].

Examples:
    app.php create-index
    app.php search --title="Терминатор" --category="Детектив" --priceFrom=100 --priceTo=1000
DOC;
    }
}
