<?php

namespace Ali;

class App
{
    public mixed $service;

    public function __construct()
    {
        $this->service = new ValidateEmail();
    }

    public function run(string $email): string
    {
        return $this->service->validate($email) ? 'valid' : 'invalid';
    }

}