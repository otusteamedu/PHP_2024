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
        $client = new Client();
        $clientCreate = $client->insert([
            'surname' => 'Тестов',
            'name' => 'Тест',
            'email' => 'test124@mail.ru',
            'phone' => '+79191112233',
            'dob' => '1997-07-29'
        ]);
        echo $clientCreate;

        // Поиск клиента по id
        $client = new Client();
        var_dump($client->findById(1));

        // Поиск клиента по id и его обновление
        $client = new Client();
        echo $client->findById(1)->update([
            'surname' => 'Петров',
            'name' => 'Петр',
        ]);

        // Поиск клиента по id и его удаление
        $client = new Client();
        echo $client->findById(1)->delete();
    }
}
