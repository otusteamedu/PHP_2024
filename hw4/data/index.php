<?php

require 'src/app.php';

if ($_POST['string'] == "") {
    echo 'no value';
} else {
    $app = new HW4\App();
    $app->run($_POST['string']);
}
