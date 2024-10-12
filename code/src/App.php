<?php

namespace AlexAgapitov\OtusComposerProject;

class App {

    public function __construct()
    {

    }

    public function run()
    {
        $args = $_SERVER['argv'];

        $ElasticSearch = new ElasticSearch();
        switch ($args[1]) {
            case 'init':
                $ElasticSearch->init();
                break;
            case 'search':
                // '{"query":{"match_all":{}}}'
                // '{"query":{"match":{"title": "Кто подставил"}}}'
                $ElasticSearch->search($args[2]);
        }
    }
}