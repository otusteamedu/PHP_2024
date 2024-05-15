<?php

declare(strict_types=1);

namespace App\Domain\ValueObject;

use App\Domain\Contract\ValueObjectInterface;
use App\Domain\Exceptions\Validate\TitleValidateException;

class Title implements ValueObjectInterface
{
    protected string $title;

    /**
     * @throws TitleValidateException
     */
    public function __construct(string $value)
    {
        $this->isTitleValid($value);
        $this->title = $value;
    }

    public function getValue(): string
    {
        return $this->title;
    }

    public function __toString(): string
    {
        return $this->title;
    }

    /**
     * @throws TitleValidateException
     */
    private function isTitleValid(string $value): void
    {
        if (mb_strlen($value) < 3) {
            throw new TitleValidateException('line length is less than 3 characters');
        }
    }
}
