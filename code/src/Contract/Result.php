<?php

namespace IraYu\Contract;

interface Result
{
    public function isSuccess(): bool;

    public function getMessage(): string;
}
