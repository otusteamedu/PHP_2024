<?php

declare(strict_types=1);

namespace App\App;

use App\Controller\CheckParenthesesController;
use App\Response\ResponseInterface;
use App\Service\ParenthesesCheckService;
use App\Validator\CheckParenthesesRequestValidator;

final class App implements AppInterface
{
    public function run(): ResponseInterface
    {
        $controller = new CheckParenthesesController(
            new CheckParenthesesRequestValidator(),
            new ParenthesesCheckService()
        );
        return $controller->checkParentheses();
    }
}
