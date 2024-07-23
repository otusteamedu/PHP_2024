<?php

declare(strict_types=1);

namespace App\Application\Exception;

class ReportNotCreatedException extends \Exception
{
    protected $message = 'Report not created';
}
