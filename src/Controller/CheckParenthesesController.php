<?php

declare(strict_types=1);

namespace App\Controller;

use App\Exception\DomainException;
use App\Request\CheckParenthesesRequest;
use App\Response\HttpResponse;
use App\Response\ResponseInterface;
use App\Service\ParenthesesCheckService;
use App\Validator\CheckParenthesesRequestValidator;
use Throwable;

final readonly class CheckParenthesesController implements CheckParenthesesControllerInterface
{
    public function __construct(
        private CheckParenthesesRequestValidator $requestValidator,
        private ParenthesesCheckService $parenthesesChecker
    ) {
    }

    public function checkParentheses(): ResponseInterface
    {
        try {
            if (empty($_SERVER['REQUEST_METHOD']) || $_SERVER['REQUEST_METHOD'] !== 'POST') {
                throw new DomainException("Доступен только метод запроса POST");
            }

            $request = new CheckParenthesesRequest((string) ($_REQUEST['string'] ?? ''));
            $this->requestValidator->validate($request);

            if (!$this->parenthesesChecker->check($request->string)) {
                throw new DomainException('Количество открытых скобок не совпадает с количеством закрытых');
            }

            $http_code = 200;
            $response_date['message'] = 'OK';
        } catch (DomainException $e) {
            $http_code = 400;
            $response_date['message'] = $e->getMessage();
        } catch (Throwable $e) {
            // логгируем ошибку
            $http_code = 400;
            $response_date['message'] = 'Произошла ошибка в процессе обработки';
        }

        header('Content-Type: application/json; charset=UTF-8');
        http_response_code($http_code);

        return new HttpResponse(
            json_encode($response_date, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE)
        );
    }
}
