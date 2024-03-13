<?php
declare(strict_types=1);
session_start();

require_once '../code/Test.php';

echo "Привет, Otus!<br>".date("Y-m-d H:i:s")."<br><br>";

$_SESSION['host'] = $_SERVER['HOSTNAME'];

$test = (new Test())->getTest();

echo $_SESSION['host'].'<br/><br/>'.$test;