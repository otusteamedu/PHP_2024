<?php

namespace Ahar\Hw16\proxy;

class Proxy implements Service
{
    private $realService;

    public function request(): string
    {
        if ($this->realService === null) {
            $this->realService = new RealService();
        }
        return "Прокси: предварительные операции\n" . $this->realService->request();
    }
}
