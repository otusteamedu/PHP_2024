<?php

declare(strict_types=1);

namespace App\Interface;

interface ChatKeepingInterface
{
  public function initializeChat(): void;
  public function keepChat(): void;
  public function stopChat(): void;
}
