<?php

declare(strict_types=1);

namespace Evgenyart\ElasticHomework;

class Run implements CommandsInterface
{
    public static function initSrorage()
    {
        $elasticInit = new ElasticInit();
        $elasticInit->init();
    }

    public static function searshInBase($arguments)
    {
        $elastic = new Elastic();
        $elastic->search($arguments);
    }
}
