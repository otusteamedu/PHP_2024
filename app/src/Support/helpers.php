<?php

declare(strict_types=1);

function human_filesize($bytes, $decimals = 2): string
{
    $sz = 'BKMGTP';
    $factor = floor((strlen((string)$bytes) - 1) / 3);
    return sprintf("%.{$decimals}f", $bytes / pow(1024, $factor)) . @$sz[$factor];
}