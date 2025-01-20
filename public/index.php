<?php

require_once dirname(__DIR__) . '/vendor/autoload.php';

echo "Проверка redis!<br>".date("Y-m-d H:i:s") ."<br><br>";

$application = new Skudashkin\Hw14\App();
echo $application->runApp();