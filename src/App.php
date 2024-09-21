<?php

declare(strict_types=1);

namespace App;

use App\Controller\ClientController;
use App\Controller\ServerController;
use App\Enum\ServiceCommand;
use Exception;

class App
{
  /**
   * @param $argv
   * @return void
   * @throws Exception
   */
  public function run($argv): void
  {
    if (in_array(ServiceCommand::ServerStart->value, $argv)) {
      (new ServerController())->run();
    }

    if (in_array(ServiceCommand::ClientStart->value, $argv)) {
      (new ClientController())->run();
    }
  }
}
