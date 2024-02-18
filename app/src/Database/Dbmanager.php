<?php

namespace Pavelsergeevich\Hw4\Database;

use \Memcached;
use \PDO;

class Dbmanager
{
    private PDO $connect;
    private Memcached $memcachedConnect;

    public function __construct()
    {
        $this->connect = $this->getConnect();
        $this->memcachedConnect = $this->getMemcachedConnect();
    }

    public function getResultIfExist(string $input): array|false
    {
        if ($cachedResult = $this->memcachedConnect->get($input)) {
            echo '[Получено из Memcached]'; //Отладочная строка
            return $cachedResult;
        }

        $sql = "SELECT * FROM staplers WHERE input = '{$input}'";
        $query = $this->connect->query($sql);
        $result = false;
        foreach ($query as $row) {
            $result = [
                'isValid' => $row['is_valid'],
                'message' => $row['message'],
            ];
            echo '[Получено из MySQL]'; //Отладочная строка
            break;
        }

        $this->memcachedConnect->set($input, $result);
        return $result;
    }

    public function addRow(string $input, string $message, bool $isValid): void
    {
        $isValidDatabased = $isValid ? 'true' : 'false';
        $sql = "INSERT INTO staplers (input, is_valid, message) VALUES ('{$input}', {$isValidDatabased}, '{$message}');";
        $this->connect->exec($sql);
    }

    /**
     * Получить объект соединения к MySQL (PDO)
     * @return PDO
     */
    private function getConnect(): PDO
    {
        $dbUser = 'root';
        $dbPass = getenv('MYSQL_ROOT_PASSWORD');
        return new PDO("mysql:host=mysql_hw4;dbname=hw4", $dbUser, $dbPass);
    }

    /**
     * Получить об]ект соединения к Memcache
     * @return
     */
    private function getMemcachedConnect()
    {
        $memcachedConnect = new Memcached('mc');
        $memcachedConnect->addServers([
            [
                'memcached_hw4',
                11211
            ]
        ]);
        return $memcachedConnect;
    }
}