<?php

declare(strict_types=1);

namespace App\Requests;

readonly class RequestWithId
{
    public function __construct(public string $id, public Request $request)
    {
    }
}
