<?php

namespace App\Enums;

enum LogLevelEnum: string
{
    case SUCCESS = 'success';
    case ERROR = 'error';
    case WARNING = 'warning';
    case INFO = 'info';
}
