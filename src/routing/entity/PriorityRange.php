<?php

declare(strict_types=1);

namespace app\routing\entity;

enum PriorityRange: int
{
    case MIN = 1;
    case MAX = 5;
}
