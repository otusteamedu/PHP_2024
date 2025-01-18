<?php

namespace KRudenko\Otus\Controller;

use KRudenko\Otus\Service\SessionService;
use KRudenko\Otus\Service\StringService;

readonly class IndexController
{
    private StringService $stringService;
    private SessionService $sessionService;

    public function __construct()
    {
        $this->stringService = new StringService();
        $this->sessionService = new SessionService();
    }

    public function handleStringRequest(): string
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(405);
            return "Данные не были отправлены методом POST.";
        }

        return $this->stringService->processString();
    }

    public function handleSessionRequest(): string
    {
        return $this->sessionService->processSession();
    }
}
