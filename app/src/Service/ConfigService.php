<?php

declare(strict_types=1);

namespace App\Service;

use Dotenv\Dotenv;

class ConfigService
{
  /**
   * @param string $key
   * @return string
   */
  public static function get(string $key): string
  {
    $dotenv = Dotenv::createArrayBacked('/data/app');

    return  $dotenv->load()[$key];
  }
}
