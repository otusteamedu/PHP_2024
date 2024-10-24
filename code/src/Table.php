<?php

namespace Kyberlox\Elastic\table;

use Kyberlox\Elastic\ESClient\ESClient as ESClient;

require 'View/vendor/autoload.php';
use LucidFrame\Console\ConsoleTable as ConsoleTable;

class Table
{
    public $data;
    public $table;

    public function __construct($data)
    {
        $this->data = json_decode($data);
    }

    public function view()
    {

        $this->table = new ConsoleTable();
        $this->table
            ->addHeader('Title')
            ->addHeader('Category')
            ->addHeader('Price')
            ->addHeader('Stock');

        for ($i = 0; $i <= count($this->data->hits->hits) - 1; $i++) {
            $line = $this->data->hits->hits[$i]->_source;

            $stock = "";
            for ($j = 0; $j <= count($line->stock) - 1; $j++) {
                $shop = $line->stock[$j]->shop;
                $stock_child = $line->stock[$j]->stock;
                $stock = "$stock $shop : $stock_child шт ";
            };

            $this->table->addRow()
                ->addColumn($line->title)
                ->addColumn($line->category)
                ->addColumn($line->price)
                ->addColumn($stock);
        };

        return $this->table;
    }
}


//$client = new ESClient("otus-shop", "elastic");
//$result = $client->search("рыцОри", "Исторический роман", 2000, 1);

//$teble = new Table($result);
//$teble->view();
