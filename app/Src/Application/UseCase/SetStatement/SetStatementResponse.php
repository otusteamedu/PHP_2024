<?php

namespace Src\Application\UseCase\SetStatement;

class SetStatementResponse
{
    public string $email;
    public function __construct(
        string $email
    )
    {
        $this->email = $email;
    }
}