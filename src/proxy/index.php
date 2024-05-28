<?php

use Ahar\Hw16\proxy\Proxy;
use Ahar\Hw16\proxy\RealService;
use Ahar\Hw16\proxy\Service;

function client_code(Service $service)
{
    echo $service->request();
}

echo "Вызов RealService через клиентский код:\n";
client_code(new RealService());

echo "\n";

echo "Вызов Proxy через клиентский код:\n";
client_code(new Proxy());
