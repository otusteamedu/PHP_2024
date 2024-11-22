<?php

session_start();
$count = $_SESSION['count'] ?? 1;

echo $count;

$_SESSION['count'] = ++$count;

