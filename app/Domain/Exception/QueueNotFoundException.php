<?php

namespace App\Domain\Exception;

class QueueNotFoundException extends \Exception
{
    protected $message = 'Queue not found';
}
