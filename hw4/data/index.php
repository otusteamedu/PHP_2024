<?php

require 'src/app.php';

$app = new HW4\App();
$app->run($_POST['string']);
