<?php

namespace SergeyShirykalov\DataMapperSample\Mapper;

use Illuminate\Support\Collection;
use PDO;
use PDOStatement;
use SergeyShirykalov\DataMapperSample\DTO\CarDTO;
use SergeyShirykalov\DataMapperSample\Entity\Car;
use SergeyShirykalov\DataMapperSample\Entity\PTS;
use SergeyShirykalov\DataMapperSample\Proxy\DriverProxy;

class CarMapper
{
    private PDOStatement $selectByIdStatement;

    private PDOStatement $selectByMarkStatement;

    private PDOStatement $selectAllStatement;

    private PDOStatement $insertStatement;

    private PDOStatement $updateStatement;

    private PDOStatement $deleteStatement;


    public function __construct(private PDO $pdo, private DriverMapper $driverMapper)
    {
        $this->pdo = $pdo;
        $this->selectByIdStatement = $pdo->prepare(
            'SELECT * FROM cars WHERE id = ?'
        );
        $this->selectByMarkStatement = $pdo->prepare(
            'SELECT * FROM cars WHERE mark = ?'
        );
        $this->selectAllStatement = $pdo->prepare(
            'SELECT * FROM cars LIMIT :limit'
        );
        $this->insertStatement = $pdo->prepare(
            'INSERT INTO cars (mark, model, vin, pts_number, pts_date) VALUES (?, ?, ?, ? ,?)'
        );
        $this->updateStatement = $pdo->prepare(
            'UPDATE cars SET
                mark = COALESCE(NULLIF(?, mark), mark),
                model = COALESCE(NULLIF(?, model), model),
                vin = COALESCE(NULLIF(?, vin), vin),
                pts_number = COALESCE(NULLIF(?, pts_number), pts_number),
                pts_date = COALESCE(NULLIF(?, pts_date), pts_date)
                WHERE id = ?'
        );
        $this->deleteStatement = $pdo->prepare(
            'DELETE FROM cars WHERE id = ?'
        );
    }

    /**
     * @throws \Exception
     */
    public function findById(int $id): ?Car
    {
        $this->selectByIdStatement->setFetchMode(PDO::FETCH_ASSOC);
        $this->selectByIdStatement->execute([$id]);

        $result = $this->selectByIdStatement->fetch();

        if ($result === false) {
            return null;
        } else {
            return $this->createCarEntityFromPdoResult($result);
        }
    }

    /**
     * @throws \Exception
     */
    public function findAll(int $limit = 10): Collection
    {
        $this->selectAllStatement->setFetchMode(PDO::FETCH_ASSOC);
        $this->selectAllStatement->bindValue(':limit', $limit, PDO::PARAM_INT);
        $this->selectAllStatement->execute();
        $result = $this->selectAllStatement->fetchAll();

        $collection = new Collection();
        foreach ($result as $car) {
            $collection->add($this->createCarEntityFromPdoResult($car));
        }
        return $collection;
    }

    /**
     * @throws \Exception
     */
    public function findByMark(string $mark): Collection
    {
        $this->selectByMarkStatement->setFetchMode(PDO::FETCH_ASSOC);
        $this->selectByMarkStatement->execute([$mark]);
        $result = $this->selectByMarkStatement->fetchAll();

        $collection = new Collection();
        foreach ($result as $car) {
            $collection->add($this->createCarEntityFromPdoResult($car));
        }
        return $collection;
    }

    /**
     * @throws \Exception
     */
    public function insert(CarDTO $carDTO): Car
    {
        $this->insertStatement->execute([
                                            $carDTO->mark,
                                            $carDTO->model,
                                            $carDTO->vin,
                                            $carDTO->ptsNumber,
                                            $carDTO->ptsDate,
                                        ]);

        return $this->createCarEntityFromPdoResult([
                                                      'id' => $this->pdo->lastInsertId(),
                                                      'mark' => $carDTO->mark,
                                                      'model' => $carDTO->model,
                                                      'vin' => $carDTO->vin,
                                                      'pts_number' => $carDTO->ptsNumber,
                                                      'pts_date' => $carDTO->ptsDate,
                                                  ]);
    }

    public function update(Car $car): bool
    {
        return $this->updateStatement->execute([
                                                   $car->getMark(),
                                                   $car->getModel(),
                                                   $car->getVin(),
                                                   $car->getPts()->getNumber(),
                                                   $car->getPts()->getDate()->format('Y-m-d'),
                                                   $car->getId()
                                               ]);
    }

    public function delete(Car $car): bool
    {
        return $this->deleteStatement->execute([$car->getId()]);
    }

    /**
     * @throws \Exception
     */
    private function createCarEntityFromPdoResult(array $pdoCarItem): Car
    {
        return new Car(
            $pdoCarItem['id'],
            $pdoCarItem['mark'],
            $pdoCarItem['model'],
            $pdoCarItem['vin'],
            new PTS(
                $pdoCarItem['pts_number'],
                $pdoCarItem['pts_date']
            ),
            new DriverProxy($this->driverMapper, $pdoCarItem['id'])
        );
    }
}