<?php

declare(strict_types=1);

namespace Rrazanov\Hw4;

class Mysql
{
    private string $login = 'root';
    private string $password = 'qwerty123!wq';
    private string $host = 'mysql';
    private string $port = '3306';

    public static $connect;

    public function __construct()
    {
        self::$connect = mysqli_connect($this->host . ':' . $this->port, $this->login, $this->password);
    }

    public function createDataTable($query)
    {
        $result = mysqli_query(self::$connect, $query);
        $arrData = [];
        while ($dataTabel = $result->fetch_object()) {
            $arrData[] = $dataTabel->text;
        }
        return $arrData;
    }
}
