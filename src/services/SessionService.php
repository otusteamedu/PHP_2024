<?php

namespace services;

class SessionService
{
    public function __construct()
    {
        session_start();
    }

    public function getSessinMessage(): string
    {
        return "<br>SessionId: " . session_id();
    }
}
