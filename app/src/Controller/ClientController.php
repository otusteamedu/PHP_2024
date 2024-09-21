<?php

declare(strict_types=1);

namespace App\Controller;

use App\Service\ClientService;

class ClientController
{
  public function run(): void
  {
    $clientService = new ClientService();
    $clientService->initializeChat();
    $clientService->keepChat();
    $clientService->stopChat();
  }
}
