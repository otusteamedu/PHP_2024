<?php

declare(strict_types=1);

namespace SlavaMakhov\OtusDatabasePatternApp;

use SlavaMakhov\OtusDatabasePatternApp\Entities\Clients\Client;

class App
{
    /**
     * Старт приложения
     *
     * @return void
     */
    public function run(): void
    {
        // Добавление клиента
        $clientCreate = new Client();
        $clientCreate->setSurname('Иванов');
        $clientCreate->setName('Иван');
        $clientCreate->setEmail('test123@mail.ru');
        $clientCreate->setPhone('+79101112233');
        $clientCreate->setAge(23);
        echo $clientCreate->insert();

        // Получение всех клиентов
        $getClients = Client::findAll();
        var_dump($getClients);

        // Поиск клиента по id
        $clientById = Client::findById(13);
        var_dump($clientById);

        // Поиск клиента по id и его обновление
        $clientUpdate = Client::findById(13);
        $clientUpdate->setSurname('Петров');
        $clientUpdate->setName('Петр');
        echo $clientUpdate->update();

        // Поиск клиента по id и его удаление
        $clientById = Client::findById(13);
        echo $clientById->delete();
    }
}
