<?php

$dsn = "mysql:host=db;dbname=otus_php";

$dbh = new PDO($dsn, 'root', 'qwerty123!wq');

$sth = $dbh->query('SELECT * FROM hw1');
$result = $sth->fetchAll(PDO::FETCH_ASSOC);
echo "<pre>\n";
print_r($result);
echo "</pre>\n";
$sth = null;
$dbh = null;