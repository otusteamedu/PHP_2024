<?php

$dsn = "mysql:host=hw5_mysql;dbname={$_SERVER['MYSQL_DATABASE']}";
try {
    $dbh = new PDO($dsn, $_SERVER['MYSQL_USER'], $_SERVER['MYSQL_PASSWORD']);
} catch (PDOException $ex) {
    echo "PDOException: \n";
    print_r($ex);
}

$sth = $dbh->query('SELECT * FROM la_la');
$result = $sth->fetchAll(PDO::FETCH_ASSOC);
echo "<pre>\n";
print_r($result);
echo "</pre>\n";
$sth = null;
$dbh = null;
