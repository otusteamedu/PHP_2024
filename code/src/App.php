<?php

namespace Kyberlox\Elastic\app;

use Kyberlox\Elastic\index\Index as Index;
use Kyberlox\Elastic\ESClient\ESClient as ESClient;
use Kyberlox\Elastic\table\Table as Table;

class App
{
    public $indexName;
    public $indexHost;
    public $index;
    public $client;

    public function __construct()
    {
        $this->indexName = "otus-shop";
        $this->indexHost = "elastic";

        //создаем индекс
        $this->index = new Index($this->indexName, $this->indexHost);
    }

    public function run($params)
    {
        //print_r($params);
        //$query = mb_convert_encoding(b"$params[1]", 'UTF-8');
        //$category = mb_convert_encoding(b"$params[2]", 'UTF-8');

        $query = $params[1];
        $category = $params[2];
        $maxPrice = (int)$params[3];
        $minStock = (int)$params[4];

        //поиск по индексу
        $this->client = new ESClient($this->indexName, $this->indexHost);
        $result = $this->client->search($query, $category, $maxPrice, $minStock);

        //выводим в таблицу
        $table = new Table($result);
        $table_display = $table->view();
        $table_display->display();
    }
}

//$app = new App();
//$app->run(["рыцОри", "Исторический роман", 2000, 1]);
