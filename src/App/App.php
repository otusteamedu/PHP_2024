<?php

declare(strict_types=1);

namespace App\App;

use App\Controller\CheckParenthesesController;
use App\Service\ParenthesesCheckService;
use App\Validator\CheckParenthesesRequestValidator;

final class App implements AppInterface
{
    public function run(): void
    {
        $controller = new CheckParenthesesController(
            new CheckParenthesesRequestValidator(),
            new ParenthesesCheckService()
        );
        $controller->checkParentheses()->send();
    }
}
