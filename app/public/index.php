<?php

use App\exceptions\AddressNotFoundException;
use App\main\AppCall;
use App\main\App;
use App\services\renders\TwigRender;
use Symfony\Component\Cache\Adapter\RedisAdapter;


require_once dirname(__DIR__) . '/vendor/autoload.php';
$config = include dirname(__DIR__) . '/main/config.php';
AppCall::call()->getConfig($config);
App::call()->run();













