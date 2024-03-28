<?php

namespace App\Contracts;

interface ConnectorInterface
{
    public function search(array $query);
}
