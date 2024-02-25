<?php

namespace hw5;

class Error
{
    public function __construct(
        private int $code,
        private string $msg
    ){}

    /**
     * @return int
     */
    public function getCode(): int
    {
        return $this->code;
    }

    /**
     * @return string
     */
    public function getMsg(): string
    {
        return $this->msg;
    }
}
