<?php
declare(strict_types=1);
namespace App\Domain\ValueObject;

class Title
{
    private string $title;

    public function __construct(string $title)
        {
            $this->assertTitleIsValid($title);
            $this->title = $title;
        }

    public function __toString(): string
    {
        return $this->title;
    }


    private function assertTitleIsValid(string $title): void
    {
        if (strlen($title) < 5) {
            throw new \InvalidArgumentException("Title is too short!");
        }
    }

}