<?php

namespace Pananin\FirstLocal\Application;

use Cocur\Slugify\Slugify;

class StringService
{
    private string $str;
    public function __construct(?string $str)
    {
        $this->setString($str);
    }

    public function setString(?string $str): static
    {
        $this->str = $str ?: '';
        return $this;
    }
    public function getString(): string
    {
        return $this->str;
    }
    public function convert(): static
    {
        $slugify = new Slugify();
        $this->setString($slugify->slugify($this->getString()));
        return $this;
    }
}