<?php

declare(strict_types=1);

namespace App\App;

use App\Response\ResponseInterface;

interface AppInterface
{
    public function run(): ResponseInterface;
}
