<?php

use Modes\IpInfo\IpInfoApi;

require __DIR__ . '/vendor/autoload.php';

$ipInfoApi = new IpInfoApi();
echo $ipInfoApi->getIpInfo('83.220.236.105');
