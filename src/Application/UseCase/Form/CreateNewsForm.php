<?php

declare(strict_types=1);

namespace App\Application\UseCase\Form;

readonly class CreateNewsForm
{
    public function __construct(public string $url)
    {
        $this->validate();
    }

    private function validate(): void
    {
        if (empty($this->url)) {
            throw new \InvalidArgumentException('URL is required');
        }

        if (!filter_var($this->url, FILTER_VALIDATE_URL)) {
            throw new \InvalidArgumentException('Invalid URL format');
        }
    }
}
