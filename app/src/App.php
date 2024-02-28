<?php

declare(strict_types=1);

namespace Lrazumov\Hw5;

class App
{
    private string $mode;

    function __construct() {
        $this->arguments = $argv;
    }

    public function run()
    {
        print_r($this->arguments);
        if (!extension_loaded('sockets')) {
            print ('The sockets extension is not loaded.');
        } else {
            print 'ok';
        }
        print "\n";
    }
}
