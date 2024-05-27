<?php
declare(strict_types=1);

namespace App\Domain\ValueObject;


class Url
{
    private string $url;

    public function __construct(string $url)
    {
        $this->assertUrlIsValid($url);
        $this->url = $url;
    }

    public function getValue(): string
    {
        return $this->url;
    }

    private function assertUrlIsValid(string $url): void
    {
        if (!preg_match( '/^(http|https):\\/\\/[a-z0-9_]+([\\-\\.]{1}[a-z_0-9]+)*\\.[_a-z]{2,5}'.'((:[0-9]{1,5})?\\/.*)?$/i' ,$url)) {
            throw new \InvalidArgumentException("URL does not correct!");
        }
    }

}