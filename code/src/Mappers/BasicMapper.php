<?php

namespace Naimushina\DataMapper\Mappers;

use Cassandra\Collection;
use Naimushina\DataMapper\IdentityMap;
use PDO;

abstract class BasicMapper
{
    protected string $tableName;
    protected array $columns;
    protected IdentityMap $identityMap;

    public function __construct(
        protected PDO $pdo
    ) {
        $this->tableName = $this->getTableName();
        $this->columns = $this->getColumns();
        $this->identityMap = $this->getIdentityMapper();
    }

    /**
     * @return string
     */
    abstract function getTableName(): string;

    /**
     * @return array
     */
    abstract function getColumns(): array;

    /**
     * @param array $result
     * @return mixed
     */
    abstract function setDTO(array $result);

    /**
     * @param int $id
     * @return object|null
     */
    public function findById(int $id): ?object
    {
        if ($this->identityMap->hasId($id)) {
            return $this->identityMap->getObject($id);
        }
        $statement = $this->pdo->prepare("SELECT * FROM {$this->tableName} WHERE id = ?");
        $statement->setFetchMode(PDO::FETCH_ASSOC);
        $statement->execute([$id]);

        $result = $statement->fetch();
        if(!$result){
            return null;
        }
        $object = $this->setDto($result);
        $this->identityMap->set($id, $object);
        return $object;
    }

    /**
     * @param object $objectToInsert
     * @return object
     */
    public function insert(object $objectToInsert): object
    {
        $columns = implode(',', $this->columns);
        $arguments = array_fill(0, count($this->columns), '?');
        $values = implode(',', $arguments);
        $statement = $this->pdo->prepare(
            "INSERT INTO {$this->tableName} ($columns) VALUES ($values)"
        );
        $insertInfo = [];
        foreach ($this->columns as $column) {
            $methodName = 'get' . $this->toCamelCase($column);
            $insertInfo[] = $objectToInsert->$methodName();
        }
        $statement->execute($insertInfo);
        $id = (int)$this->pdo->lastInsertId();
        $objectToInsert->setId($id);
        $this->identityMap->set($id, $objectToInsert);
        return $objectToInsert;
    }

    /**
     * @param object $updatedObject
     * @return bool
     */
    public function update(object $updatedObject)
    {
        $statementText = "UPDATE {$this->tableName} SET ";
        $updateValues = [];
        foreach ($this->columns as $column) {
            if ($column === 'id') {
                break;
            }
            $statementText .= "$column = ?";
            $methodName = 'get' . $this->toCamelCase($column);
            $updateValues[] = $updatedObject->$methodName();
        }
        $statementText .= "WHERE id = ?";
        $updateValues[] = $updatedObject->getId();
        $statement = $this->pdo->prepare($statementText);
        $result = $statement->execute($updateValues);
        $this->identityMap->set($updatedObject->getId(), $updatedObject);
        return $result;
    }

    public function delete(int $id): bool
    {
        $statement = $this->pdo->prepare(
            "DELETE FROM {$this->tableName} WHERE id = ?"
        );
        return $statement->execute([$id]);
    }

    /**
     * @param $limit
     * @param $offset
     * @return array
     */
    public function getAll( $limit = 100, $offset = 0): array
    {
        $statement = $this->pdo->prepare(
            "SELECT * FROM {$this->tableName} LIMIT :limit OFFSET :offset"
        );
        $statement->setFetchMode(PDO::FETCH_ASSOC);
        $statement->execute([':limit' => $limit, ':offset' => $offset]);


        $result = $statement->fetchAll();
        $items = [];
        if($result){
            foreach ($result as $raw){
                $object = $this->setDto($raw);
                $this->identityMap->set($object->getId(), $object);
                $items[] = $object;
            }
        }
        return $items;
    }


    /**
     * @param $string
     * @return string
     */
    public function toCamelCase($string): string
    {
        return str_replace(' ', '',
            ucwords(str_replace(['-', '_'],
                ' ', $string))
        );
    }

    /**
     * @return IdentityMap
     */
    private function getIdentityMapper(): IdentityMap
    {
        return new IdentityMap();
    }


}