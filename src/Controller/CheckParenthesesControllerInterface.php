<?php

declare(strict_types=1);

namespace App\Controller;

use App\Response\ResponseInterface;

interface CheckParenthesesControllerInterface
{
    public function checkParentheses(): ResponseInterface;
}
