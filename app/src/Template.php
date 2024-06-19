<?php

declare(strict_types=1);

namespace App\src;

class Template
{
    public function __construct(
        private string $template = '',
        private int $tab = 0
    ) {
    }

    public function addRow(string $row): void
    {
        $tab = str_repeat('   ', $this->tab);
        $this->template .= PHP_EOL . $tab . $row;
    }

    public function incrementTab(): void
    {
        $this->tab++;
    }

    public function decrementTab(): void
    {
        $this->tab--;
    }

    public function __invoke(): string
    {
        return $this->template;
    }
}
