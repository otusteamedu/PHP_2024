<?php

declare(strict_types=1);

namespace App\App;

use App\Controller\CheckParenthesesController;
use App\Exception\DomainException;
use App\Service\ParenthesesCheckService;
use App\Validator\CheckParenthesesRequestValidator;
use Throwable;

final class App implements AppInterface
{
    public function run(): void
    {
        header('Content-Type: application/json; charset=UTF-8');
        try {
            $controller = new CheckParenthesesController(
                new CheckParenthesesRequestValidator(),
                new ParenthesesCheckService()
            );
            $controller->checkParentheses();
            http_response_code(200);
            $response['message'] = 'OK';
        } catch (DomainException $e) {
            http_response_code(400);
            $response['message'] = $e->getMessage();
        } catch (Throwable $e) {
            // логгируем ошибку
            http_response_code(400);
            $response['message'] = 'Произошла ошибка в процессе обработки';
        }

        echo json_encode($response, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
    }
}
