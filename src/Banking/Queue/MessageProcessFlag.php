<?php

declare(strict_types=1);

namespace App\Banking\Queue;

enum MessageProcessFlag: int
{
    case ACKNOWLEDGED = 1;
    case NEED_REQUEUE = 0;
    case REJECTED = -1;
}
