<?php


namespace App\services;

use App\modules\Good;
use App\traits\TSingleton;
use App\modules\Model;

class DB implements IDB
{
    private $config = [];
    protected $connect;

    public function __construct($config)
    {
        $this->config = $config;
    }

    protected function getConnection()
    {
        if (empty($this->connect)) {
            try {
                $this->connect = new \PDO(
                    $this->getPrepareDsnString(),
                    $this->config['username'],
                    $this->config['password']
                );
                $this->connect->setAttribute
                (
                    \PDO::ATTR_DEFAULT_FETCH_MODE,
                    \PDO::FETCH_ASSOC);
            }
            catch(\PDOException $e)
            {
                var_dump($e);
            }
           
        }

        return $this->connect;
    }

    protected function getPrepareDsnString()
    {
        return sprintf(
            '%s:host=%s;dbname=%s;charset=%s;port=%s',
            $this->config['driver'],
            $this->config['host'],
            $this->config['db'],
            $this->config['charset'],
            $this->config['port']
        );
    }

    protected function query($sql, $params = [])
    {
        $PDOStatement = $this->getConnection()->prepare($sql);
        $PDOStatement->execute($params);
        return $PDOStatement;
    }

    public function find(string $sql, $params = [])
    {
        return $this->query($sql, $params)->fetch();
    }

    public function findAll(string $sql, $params = [])
    {
        return $this->query($sql,$params)->fetchAll();
    }

    public function execute(string $sql, $params = [])
    {
        return $this->query($sql, $params);
    }

    public function queryObj(string $sql, $class, $params = [])
    {
        $PDOStatement = $this->query($sql, $params);
        $PDOStatement->setFetchMode(\PDO::FETCH_CLASS, $class);
        return $PDOStatement->fetch();
    }

    public function queryObjs(string $sql, $class, $params = [])
    {
        $PDOStatement = $this->query($sql, $params);
        $PDOStatement->setFetchMode(\PDO::FETCH_CLASS, $class);
        return $PDOStatement->fetchAll();

    }

    public function lastInsertId()
    {
        return $this->getConnection()->lastInsertId();
    }


}