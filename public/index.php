<?php

require_once dirname(__DIR__) . '/vendor/autoload.php';

$application = new Skudashkin\Hw16\App();
echo $application->runApp();