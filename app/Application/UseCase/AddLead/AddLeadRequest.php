<?php

namespace App\Application\UseCase\AddLead;

class AddLeadRequest
{
    public function __construct(
        public string $userName,
        public string $email,
        public string $body,
    )
    {
    }

}
