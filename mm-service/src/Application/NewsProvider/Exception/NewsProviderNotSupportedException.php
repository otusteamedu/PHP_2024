<?php

declare(strict_types=1);

namespace App\Application\NewsProvider\Exception;

class NewsProviderNotSupportedException extends \RuntimeException
{
    public function __construct()
    {
        parent::__construct('News provider for given news determination attributes is not supported yet');
    }
}
