<?php

declare(strict_types=1);

namespace App\Application\UseCase;

class GetStatusStatementResponse
{
    public $data;

    public function __construct(array $data)
    {
        $this->data = $data;
    }
}
