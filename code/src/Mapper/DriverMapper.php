<?php

namespace SergeyShirykalov\DataMapperSample\Mapper;

use PDO;
use PDOStatement;
use SergeyShirykalov\DataMapperSample\DTO\DriverDTO;
use SergeyShirykalov\DataMapperSample\Entity\Driver;

class DriverMapper
{
    private PDO $pdo;

    private PDOStatement $selectByIdStatement;

    private PDOStatement $selectByCarIdStatement;

    private PDOStatement $insertStatement;

    private PDOStatement $updateStatement;

    private PDOStatement $deleteStatement;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
        $this->selectByIdStatement = $pdo->prepare(
            'SELECT * FROM drivers WHERE id = ?'
        );
        $this->selectByCarIdStatement = $pdo->prepare(
            'SELECT * FROM drivers WHERE car_id = ?'
        );
        $this->insertStatement = $pdo->prepare(
            'INSERT INTO drivers (car_id, name, birth_date, license_number) VALUES (?, ?, ?, ?)'
        );
        $this->updateStatement = $pdo->prepare(
            'UPDATE drivers SET car_id = ?, name = ?, birth_date = ?, license_number = ? WHERE id = ?'
        );
        $this->deleteStatement = $pdo->prepare(
            'DELETE FROM drivers WHERE id = ?'
        );
    }

    /**
     * @throws \Exception
     */
    public function findById(int $id): ?Driver
    {
        $this->selectByIdStatement->setFetchMode(PDO::FETCH_ASSOC);
        $this->selectByIdStatement->execute([$id]);

        $result = $this->selectByIdStatement->fetch();

        if ($result === false) {
            return null;
        } else {
            return self::createDriverEntityFromPdoResult($result);
        }
    }

    /**
     * @throws \Exception
     */
    public function findByCarId(int $id): ?Driver
    {
        $this->selectByCarIdStatement->setFetchMode(PDO::FETCH_ASSOC);
        $this->selectByCarIdStatement->execute([$id]);

        $result = $this->selectByCarIdStatement->fetch();

        if ($result === false) {
            return null;
        } else {
            return self::createDriverEntityFromPdoResult($result);
        }
    }

    /**
     * @throws \Exception
     */
    public function insert(DriverDTO $driverDTO): Driver
    {
        $this->insertStatement->execute([
                                            $driverDTO->carId,
                                            $driverDTO->name,
                                            $driverDTO->birthDate,
                                            $driverDTO->licenseNumber,
                                        ]);

        return self::createDriverEntityFromPdoResult([
                                                      'id' => $this->pdo->lastInsertId(),
                                                      'car_id' => $driverDTO->carId,
                                                      'name' => $driverDTO->name,
                                                      'birth_date' => $driverDTO->birthDate,
                                                      'license_number' => $driverDTO->licenseNumber,
                                                  ]);
    }

    public function update(Driver $driver): bool
    {
        return $this->updateStatement->execute([
                                                   $driver->getName(),
                                                   $driver->getBirthDate()->format('Y-m-d'),
                                                   $driver->getLicenseNumber(),
                                                   $driver->getId()
                                               ]);
    }

    public function delete(Driver $driver): bool
    {
        return $this->deleteStatement->execute([$driver->getId()]);
    }

    /**
     * @throws \Exception
     */
    private static function createDriverEntityFromPdoResult(array $pdoDriverItem): Driver
    {
        return new Driver(
            $pdoDriverItem['id'],
            $pdoDriverItem['car_id'],
            $pdoDriverItem['name'],
            new \DateTimeImmutable($pdoDriverItem['birth_date']),
            $pdoDriverItem['license_number']
        );
    }
}