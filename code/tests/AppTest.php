<?php

namespace tests;

use Naimushina\Chat\App;
use PHPUnit\Framework\TestCase;

class AppTest extends TestCase
{
    /**
     * @return void
     * @throws \Exception
     */
    public function testNoArguments()
    {
        $this->expectExceptionMessage('Укажите тип приложения - client или server');
        $_SERVER['argv'][1] = null;
        $app  = new App();
        $app->run();
    }

    /**
     * @return void
     * @throws \Exception
     */
    public function testWrongArguments()
    {
        $this->expectExceptionMessage('Укажите тип приложения - client или server');
        $_SERVER['argv'][1] = 'wrong';
        $app  = new App();
        $app->run();
    }
}
