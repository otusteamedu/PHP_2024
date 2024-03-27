<?php

declare(strict_types=1);

namespace Hukimato\EsApp;

class ParamsParser
{
    const LONG_PARAMS = ['title::', 'min-price::', 'max-price::', 'category::'];

    protected array $options = [];

    public function parse(): array
    {
        $this->options = getopt('', static::LONG_PARAMS);

        return [
            'max-price' => $this->getMaxPrice(),
            'min-price' => $this->getMinPrice(),
            'title' => $this->getTitle(),
            'category' => $this->getCategory(),
        ];
    }

    protected function getMaxPrice(): int|null
    {
        if (isset($this->options['max-price'])) {
            return (int) $this->options['max-price'];
        }
        return null;
    }

    protected function getMinPrice(): int|null
    {
        if (isset($this->options['min-price'])) {
            return (int)$this->options['min-price'];
        }
        return null;
    }

    protected function getTitle(): string|null
    {
        if (!empty($this->options['title'])) {
            return $this->options['title'];
        }
        return null;
    }

    protected function getCategory(): string|null
    {
        if (!empty($this->options['category'])) {
            return $this->options['category'];
        }
        return null;
    }
}