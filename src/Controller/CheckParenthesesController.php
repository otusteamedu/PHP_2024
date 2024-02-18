<?php

declare(strict_types=1);

namespace App\Controller;

use App\Exception\DomainException;
use App\Request\CheckParenthesesRequest;
use App\Service\ParenthesesCheckService;
use App\Validator\CheckParenthesesRequestValidator;

final readonly class CheckParenthesesController implements CheckParenthesesControllerInterface
{
    public function __construct(
        private CheckParenthesesRequestValidator $requestValidator,
        private ParenthesesCheckService $parenthesesChecker
    ) {
    }

    /**
     * @throws DomainException
     */
    public function checkParentheses(): void
    {
        if (empty($_SERVER['REQUEST_METHOD']) || $_SERVER['REQUEST_METHOD'] !== 'POST') {
            throw new DomainException("Доступен только метод запроса POST");
        }

        $request = new CheckParenthesesRequest((string) ($_REQUEST['string'] ?? ''));
        $this->requestValidator->validate($request);

        if (!$this->parenthesesChecker->check($request->string)) {
            throw new DomainException('Количество открытых скобок не совпадает с количеством закрытых');
        }
    }
}