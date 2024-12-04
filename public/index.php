<?php

require_once dirname(__DIR__) . '/vendor/autoload.php';

echo "Проверка e-mail по post запросу!<br>".date("Y-m-d H:i:s") ."<br><br>";

$application = new Skudashkin\Hw5\App();
echo $application->runApp();