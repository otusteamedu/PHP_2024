<?php
declare(strict_types=1);


session_start();
echo "Привет, Otus!<br>".date("Y-m-d H:i:s")."<br><br>";

$_SESSION['host'] = $_SERVER['HOSTNAME'];

echo $_SESSION['host'].'<br/><br/>';