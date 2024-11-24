<?php

declare(strict_types=1);

namespace AnatolyShilyaev\MyComposerPackage;

class BadRequestException extends \Exception
{
    public function __construct($message)
    {
        parent::__construct($message);
        http_response_code(400);
        header('Content-Type: application/json; charset=windows-1251');
        echo json_encode(['error' => $message]);
        exit;
    }
}
