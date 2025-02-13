<?php

declare(strict_types=1);

namespace App;

interface Storage
{
    public function search(array $params): array;
}
