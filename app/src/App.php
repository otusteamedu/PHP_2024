<?php


namespace Kagirova\Hw14;


class App
{

    public function run(){
        $elastic = new Elastic('https://localhost:9200', 'elastic', 'pass123');
    }
}