<?php

declare(strict_types=1);

class Parser
{
    protected string $string;

    public function setString(string $string): self
    {
        $this->string = $string;

        return $this;
    }

    public function process(): string
    {
        $string = $this->string;

        do {
            $string = $this->removeTag($string);
        } while ($this->hasTag($string));

        return $string;
    }

    public function hasTag(string $tag): bool
    {
        return is_int(mb_strpos($tag, '()'));
    }

    public function removeTag(string $string): string
    {
        return str_replace('()', '', $string);
    }
}