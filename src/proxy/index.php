<?php

interface Service
{
    public function request(): string;
}

class RealService implements Service
{
    public function request(): string
    {
        return "Реальный сервис: выполнение запроса\n";
    }
}

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

function clientCode(Service $service)
{
    echo $service->request();
}

echo "Вызов RealService через клиентский код:\n";
clientCode(new RealService());

echo "\n";

echo "Вызов Proxy через клиентский код:\n";
clientCode(new Proxy());
