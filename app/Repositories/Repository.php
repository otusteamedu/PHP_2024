<?php


namespace App\Repositories;

use App\main\AppCall;
use App\services\DB;
use App\entities\Entity;

abstract class Repository
{
    /**
     * @var DB
     */
    public $bd;


    public function __construct()
    {
        $this->bd = AppCall::call()->db;
    }

    /**
     * Возвращает имя таблицы в базе данных
     * @return string
     */
    abstract public function getTableName(): string;

    /**
     * Возвращает имя сущности
     * @return string
     */
    abstract public function getEntityClass(): string ;

    /**
     * Возвращает обьект с Репозиторием
     * @return object
     */
    abstract public function getRepositoryClass();

    public function getOne($id)
    {
        $tableName = $this->getTableName();
        $sql = "SELECT * FROM {$tableName} WHERE id = :id";
        return $this->bd->queryObj($sql, $this->getEntityClass(), [':id' => $id]);
    }



    public function getAll()
    {
        $tableName = $this->getTableName();
        $sql = "SELECT * FROM {$tableName}";
        return $this->bd->queryObjs($sql, $this->getEntityClass());
    }
    /**
     * @param Entity $entity
     */
    public function insert( $entity)
    {
        $dataToInsert = [];
        $params = [];

        foreach ($entity as $property => $value) {
            if (empty($value)) {
                continue;
            }
            $dataToInsert[] = $property;
            $params[":{$property}"] = $value;
        }


        $data = implode(", ", $dataToInsert);
        $values = implode(", ", array_keys($params));
        $tableName = $this->getTableName();

        $sql = "INSERT INTO {$tableName}( {$data}) VALUES ($values)";
        $this->bd->execute($sql, $params);
        $entity->id = $this->bd->lastInsertId();
    }

    public function delete($entity)
    {
        $tableName = $this->getTableName();
        $sql = "DELETE FROM {$tableName} WHERE id= :id ";
        return $this->bd->execute($sql, [':id' => $entity->id]);
    }

    protected function update($entity)
    {
        $allDataToInsert = [];
        $allValues = [];

        foreach ($entity as $data => $value) {

            if (empty($value)){
                continue;
            }

            if ($data == "statusOptions"|| $data == "summary" || $data == "order_list"){
                continue;
            }
            if ($data == 'id') {
                $allValues[":$data"] = $value;
                continue;
            }

            $allValues[":$data"] = $value;
            $allDataToInsert[] = "$data = :{$data}";

        }

        $strToSetUpdate = implode(", ", $allDataToInsert);

        $tableName = $this->getTableName();

        $sql = "UPDATE {$tableName} SET  {$strToSetUpdate} WHERE id = :id ";

        return $this->bd->execute($sql, $allValues);

    }

    public function save($entity)
    {
        if (empty($entity->id)) {
            $this->insert($entity);
            return;
        }
        return $this->update($entity);
    }

}