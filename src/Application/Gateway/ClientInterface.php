<?php

declare(strict_types=1);

namespace App\Application\Gateway;

use App\Application\Gateway\Request\NewsRequest;
use App\Application\Gateway\Response\NewsResponse;

interface ClientInterface
{
    public function get(NewsRequest $request): NewsResponse;
}
