<?php

namespace IraYu\OtusHw4;

interface Result
{
    public function isSuccess(): bool;

    public function getMessage(): string;
}
