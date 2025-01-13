<?php

declare(strict_types=1);

namespace AnatolyShilyaev\Hw11;

use AnatolyShilyaev\Hw11\Storage\RedisHelper;

class App
{
    public function run(): void
    {
        try {
            $redis = new RedisHelper();
            switch ($_POST['type']) {
                case 'add':
                    $redis->add(
                        'event:' . rand(1, 10),
                        rand(1_000, 10_000),
                        '{param1 = ' . rand(1, 5) . ', param2 = ' . rand(1, 5) . '}'
                    );
                    print_r($redis->get('events'));
                    break;
                case 'get':
                    $request = ['param1' => rand(1, 5), 'param2' => rand(1, 5)];
                    $bestEvent = $redis->findBestMatch($request);
                    if (is_null($bestEvent)) {
                        echo "no matches found";
                    } else {
                        print_r($bestEvent);
                    }
                    break;
                case 'del':
                    $redis->clear();
                    echo ('redis is empty');
                    break;
                default:
                    # code...
                    break;
            }
        } catch (\PDOException $e) {
            echo $e->getMessage();
        }
    }
}
