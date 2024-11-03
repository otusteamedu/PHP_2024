<?php

declare(strict_types=1);

namespace App\Domain\Entity;

class Report
{
    public function __construct(
        private string $html
    ) {
    }

    public function getHtml(): string
    {
        return $this->html;
    }
}
