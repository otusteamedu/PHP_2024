<?php
error_reporting(E_ALL);
mb_internal_encoding("UTF-8");

require 'autoload.php';

use \Core\App;

$App = new App();
$App->run();