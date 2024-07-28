<?php

namespace App\Domain\Enum\QueueReport;

enum QueueReportStatusEnum: string
{
    case SUCCESS = 'success';
    case ERROR = 'error';
    case AWAIT = 'await';
}
