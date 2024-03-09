<?php

declare(strict_types=1);

namespace ChatOtus\App;

interface SocketChat
{
    public function run(string $socketPath);
}