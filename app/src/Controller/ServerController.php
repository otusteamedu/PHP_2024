<?php

declare(strict_types=1);

namespace App\Controller;

use App\Service\ServerService;

class ServerController
{
  public function run(): void
  {
    $serverService = new ServerService();
    $serverService->initializeChat();
    $serverService->beginChat();
    $serverService->keepChat();
    $serverService->stopChat();
  }
}
