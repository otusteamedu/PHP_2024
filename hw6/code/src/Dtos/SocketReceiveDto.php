<?php

declare(strict_types=1);

namespace GoroshnikovP\Hw6\Dtos;

class SocketReceiveDto
{
    public string $data = '';
    public int $ReceivedBytes = 0;
    public string $from = '';
}
