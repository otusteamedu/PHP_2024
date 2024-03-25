<?php

declare(strict_types=1);

namespace hw14;

use hw14\elastic\Search;
use hw14\elastic\Init;
use hw14\elastic\Test;

class Creator
{
    /**
     * @return string
     */
    public function run()
    {
        $method = $_SERVER["argv"][1] ?? '';
        $value = $_SERVER["argv"][2] ?? '';
        switch ($method) {
            case Dictionary::INIT:
                return (new Init())->exec();
            case Dictionary::SEARCH:
                $search = new Search();
                $search->setQuery($value);
                return $search->exec();
            case Dictionary::TEST:
            default:
                return (new Test())->exec();
        }
    }

}
