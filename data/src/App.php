<?php
declare(strict_types=1);

namespace App;


use App\Storage\Storage;

class App
{
    public function run(array $argv) {
        $arguments = $argv;

        array_shift($arguments);

        $storage = new Storage();
        if (in_array('addEvent', $arguments)) {
            return $storage->addEvent($arguments);
        }
        if (in_array('deleteEvents', $arguments)) {
            return $storage->deleteEvents();
        }
        if (in_array('getEvent',$arguments)) {
            return $storage->getEvent($arguments);
        }
        return 'Command not found';
    }

}