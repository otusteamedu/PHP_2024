<?php

declare(strict_types=1);

namespace Pozys\OtusShop\Services;

use dekor\ArrayToTextTable;
use Docopt;
use Docopt\Response;
use Exception;

class IOProcessor
{
  public function parseInput(): array
  {
    $input = $this->readInput();

    return match (true) {
      $input['find'] => $this->parseFind($input),
      $input['bulk'] => $this->parsBulk($input),
      default => throw new Exception('Unknown command!'),
    };
  }

  public function printArray(array $data): void
  {
    if (count($data) === 0) {
      print_r('Nothing to print...' . PHP_EOL);
      return;
    }

    print_r((new ArrayToTextTable($data))->render() . PHP_EOL);
  }

  public function print(string $message): void
  {
    print_r($message . PHP_EOL);
  }

  public function readJSON(string $path): array
  {
    if (!file_exists($path)) {
      throw new Exception('File not found!');
    }

    $jsonData = file($path);

    return array_map(fn ($item) => json_decode($item, true, flags: JSON_THROW_ON_ERROR), $jsonData);
  }

  private function parseFind(Response $args): array
  {
    $result = ['command' => 'search'];
    $queryFields = [];
    $allowedFields = ['category', 'title', 'price', 'operator', 'in_stock'];

    foreach ($args as $key => $value) {
      if (!(str_starts_with($key, '--') && $value !== null && $value !== false)) {
        continue;
      }

      $key = ltrim($key, '--');
      if (!in_array($key, $allowedFields)) {
        continue;
      }

      $queryFields[$key] = $value;
    }

    $result['query'] = $queryFields;

    return $result;
  }

  private function parsBulk(Response $args): array
  {
    return ['command' => 'bulk', 'path' => $args['<path-to-file>']];
  }

  private function readInput(): Response
  {
    $doc = <<<'DOC'
    Book Shop.

    Usage:
      ./app find [--category=<category>] [--title=<title>] [(--price=<price> --operator=<operator>)] [--in_stock] 
      ./app bulk <path-to-file>                                                                                   
      ./app (-h | --help)                                                                                         

    Commands:
      find  Find books.
      bulk  Upload data.

    Options:
      -h --help                 Show this screen.
      --category='<category>'   Book category.
      --title='<title>'         Full or partial book title.
      --price=<price>           Price range.
      --operator=<operator>     One of: '=', '>', '<', '>=', '<='.
      --in_stock                Show only books in stock.

    Examples:
      ./app find --price='1000.01' --operator='<=' --category='фантастика' --title='похождения' --in_stock
      ./app bulk './config/books.json'
    DOC;

    return Docopt::handle($doc);
  }
}
