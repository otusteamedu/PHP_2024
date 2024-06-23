<?php

//simple counter to test sessions. should increment on each page reload.
session_start();
$count = $_SESSION['count'] ?? 1;
echo $count;
$_SESSION['count'] = ++$count;
