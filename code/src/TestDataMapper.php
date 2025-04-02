<?php

namespace SergeyShirykalov\DataMapperSample;

use SergeyShirykalov\DataMapperSample\DTO\CarDTO;
use SergeyShirykalov\DataMapperSample\DTO\DriverDTO;
use SergeyShirykalov\DataMapperSample\Mapper\CarMapper;
use SergeyShirykalov\DataMapperSample\Mapper\DriverMapper;


class TestDataMapper
{
    public static function execute()
    {
        $pdo = new \PDO('mysql:host=mysql;dbname=pattern_data_mapper', 'root', '');

        $driverDataMapper = new DriverMapper($pdo);
        $carDataMapper = new CarMapper($pdo, $driverDataMapper);

        //****************************
        // Вставляем новые записи в БД
        //****************************
        // автомобиль 1
        $car = $carDataMapper->insert(CarDTO::fromArray([
                                                            'mark' => 'Nissan',
                                                            'model' => 'Primera',
                                                            'vin' => 'NSKDSIIWWE3223',
                                                            'ptsNumber' => '123456789',
                                                            'ptsDate' => '2010-01-12',
                                                        ]));
        // водитель 1
        $driver = $driverDataMapper->insert(DriverDTO::fromArray([
                                                                     'carId' => $car->getId(),
                                                                     'name' => 'John Doe',
                                                                     'birthDate' => '1980-01-01',
                                                                     'licenseNumber' => '123456789',
                                                                 ]));

        // автомобиль 2
        $car = $carDataMapper->insert(CarDTO::fromArray([
                                                            'mark' => 'Nissan',
                                                            'model' => 'Almera',
                                                            'vin' => 'VIN2',
                                                            'ptsNumber' => '987654321',
                                                            'ptsDate' => '2011-02-14'
                                                        ]));

        // водитель 2
        $driver = $driverDataMapper->insert(DriverDTO::fromArray([
                                                                     'carId' => $car->getId(),
                                                                     'name' => 'Almera driver',
                                                                     'birthDate' => '1970-02-01',
                                                                     'licenseNumber' => '123456789',
                                                                 ]));

        // автомобиль 3
        $car = $carDataMapper->insert(CarDTO::fromArray([
                                                            'mark' => 'Toyota',
                                                            'model' => 'Rav4',
                                                            'vin' => 'VIN3',
                                                            'ptsNumber' => '1111111111',
                                                            'ptsDate' => '2011-02-14'
                                                        ]));
        // водитель 3
        $driver = $driverDataMapper->insert(DriverDTO::fromArray([
                                                                     'carId' => $car->getId(),
                                                                     'name' => 'Toyota driver',
                                                                     'birthDate' => '1990-01-01',
                                                                     'licenseNumber' => '123456789',
                                                                 ]));


        //****************************
        // Тестовые операции
        //****************************
        echo PHP_EOL . 'Последний созданный автомобиль: ' . PHP_EOL;
        self::print_car($car);

        // обновляем запись в БД
        $car->setVin('NEW_VIN_NUMBER');
        $carDataMapper->update($car);

        // получаем автомобиль по id
        $carById = $carDataMapper->findById($car->getId());
        echo PHP_EOL . 'Обновляем VIN: ' . PHP_EOL;
        self::print_car($car);

        // проверка LazyLoad, получаем имя последнего водителя
        echo PHP_EOL . 'Проверка LazyLoad, получаем последнего водителя: ' . PHP_EOL;
        echo $carById->getDriver()->getName() . ', birthDate: ' . $carById->getDriver()->getBirthDate()->format('Y-m-d') . PHP_EOL;

        // получаем все автомобили по марке
        $carsByMark = $carDataMapper->findByMark('Nissan');
        echo PHP_EOL . 'Список всех автомобилей по марке Nissan: ' . PHP_EOL;
        foreach ($carsByMark as $car) {
            self::print_car($car);
        }

        // получаем все автомобили
        $carsAll = $carDataMapper->findAll();
        echo PHP_EOL . 'Список всех автомобилей: ' . PHP_EOL;
        foreach ($carsAll as $car) {
            self::print_car($car);
        }

        // удалим автомобиль, полученный по Id
        $carDataMapper->delete($carById);

        // получаем все автомобили снова, убедимся, что автомобиль удален
        $carsAll = $carDataMapper->findAll();
        echo PHP_EOL . 'Список всех автомобилей после удаления последнего автомобиля: ' . PHP_EOL;
        foreach ($carsAll as $car) {
            self::print_car($car);
        }

        // удаляем все автомобили
        foreach ($carsAll as $car) {
            $carDataMapper->delete($car);
        }

        // получаем все автомобили снова, убедимся, что cписок пуст
        $carsAll = $carDataMapper->findAll();
        echo PHP_EOL . 'Пустой список после удаления всех авто: ' . PHP_EOL;
        foreach ($carsAll as $car) {
            self::print_car($car);
        }
    }

    /**
     * Вспомогательная функция вывода автомобиля
     * @param $car
     * @return void
     */
    private static function print_car($car): void
    {
        echo 'car_id = ' . $car->getId() . ', ' . $car->getMark() . ' ' . $car->getModel() . ', vin = ' . $car->getVin() . PHP_EOL;
    }
    
}