<?php

include_once 'App.php';
include_once 'CheckEmails.php';

echo "Проверка e-mail по post запросу!<br>".date("Y-m-d H:i:s") ."<br><br>";

$application = new App();
echo $application->runApp();