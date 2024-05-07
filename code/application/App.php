<?php
declare(strict_types=1);

namespace App;

use App\Entities\BookSearch;
use Console_Table;


class App
{
    public function run(array $argv)
    {
        $search = new BookSearch($argv);
        return $this->showTableResult($search->search());
    }

    private function showTableResult($result) {
        $tbl = new Console_Table();
        $tbl->setHeaders(array('Название','Релевантность','Стоимость','Наличие'));

        foreach ($result as $item) {
            $tbl->addRow(array($item['title'], $item['score'], $item['price'], $item['stock']));
        }

        return $tbl->getTable();
    }

}