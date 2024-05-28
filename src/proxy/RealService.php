<?php

namespace Ahar\Hw16\proxy;

class RealService implements Service
{
    public function request(): string
    {
        return "Реальный сервис: выполнение запроса\n";
    }
}
