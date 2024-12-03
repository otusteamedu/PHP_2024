<?php

declare(strict_types=1);

namespace App;

class Counter
{
    public static function addCount(): int
    {
        $count = (int)Redis::get('count_view');
        Redis::set('count_view', ++$count);

        return $count;
    }

}