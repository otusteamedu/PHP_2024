<?php

namespace Naimushina\ElasticSearch;

use PDO;

abstract class BasicMapper
{
    private $tableName;
    private array $columns;
    private $dto;

    public function __construct(
        protected PDO $pdo
    )
    {
        $this->tableName = $this->getTableName();
        $this->columns = $this->getColumns();
    }

    abstract function getTableName(): string;

    abstract function getColumns(): array;

    abstract function setDTO(array $result);

    public function findById(int $id): object
    {
       $statement =  $this->pdo->prepare("SELECT * FROM {$this->tableName} WHERE id = ?");
       $statement->setFetchMode(PDO::FETCH_ASSOC);
       $statement->execute([$id]);
       $result = $statement->fetch();
       return $this->setDto($result);
    }

    public function insert(object $objectToInsert): object
    {

        $statement =  $this->pdo->prepare(
            "INSERT INTO {$this->tableName} ({array_implode(',', $this->columns)}) VALUES (?, ?, ?)"
        );
        $insertInfo = [];
        foreach ($this->columns as $column){
            $methodName = 'get' . $this->toCamelCase($column);
            $insertInfo[] = $objectToInsert->$methodName();
        }
        $statement->execute($insertInfo);
        $objectToInsert->setId((int)$this->pdo->lastInsertId());
        return $objectToInsert;
    }
    public function update(object $updatedObject)
    {
        $statementText = "UPDATE {$this->tableName} SET ";
        $updateValues = [];
        foreach ($this->columns as $column){
            if($column === 'id'){
                break;
            }
            $statementText .= "$column = ?";
            $methodName = 'get' . $this->toCamelCase($column);
            $updateValues[] = $updatedObject->$methodName();
        }
        $statementText .= "WHERE id = ?";
        $updateValues[] = $updatedObject->getId();

        $statement =  $this->pdo->prepare($statementText);
        return $statement->execute($updateValues);
    }
    public function delete(int $id): bool
    {
        $statement = $this->pdo->prepare(
            "DELETE FROM {$this->tableName} WHERE id = ?"
        );
        return $statement->execute([$id]);
    }


    public function toCamelCase($string){
        $string = str_replace(' ', '',
            ucwords(str_replace(['-', '_'],
                ' ', $string))
        );

        return $string;
    }




}