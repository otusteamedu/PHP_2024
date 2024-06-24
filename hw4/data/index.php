<?php

require 'src/app.php';

if ($_POST['string'] == "") {
    echo 'no value';
} else {
    $app = new App();
    $app->run($_POST['string']);
}
