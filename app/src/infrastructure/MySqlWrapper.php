<?php

namespace Akornienko\App\infrastructure;

class MySqlWrapper
{
    public function connect(): void {
        $mySqlHost = getenv("MYSQL_HOST");
        $mySqlUserName = getenv("MYSQL_USER");
        $mySqlPassword = getenv("MYSQL_PASSWORD");
        $mySqlDb = getenv("MYSQL_DATABASE");
        $mySqlPort = getenv("MYSQL_PORT");

        $link = mysqli_connect($mySqlHost, $mySqlUserName, $mySqlPassword, $mySqlDb, $mySqlPort);

        if ($link === false){
            print_r("<br>");
            print("Ошибка: Невозможно подключиться к MySQL " . mysqli_connect_error());
        }
        else {
            print_r("<br>");
            print("Соединение установлено успешно");
        }
    }
}