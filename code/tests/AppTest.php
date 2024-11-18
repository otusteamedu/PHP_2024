<?php

namespace Naimushina\Chat;

use Exception;
use PHPUnit\Framework\Attributes\TestWith;
use PHPUnit\Framework\TestCase;

class AppTest extends TestCase
{
    /**
     * @return void
     * @throws Exception
     */
    public function testNoArguments()
    {
        $this->expectExceptionMessage('Укажите тип приложения - client или server');
        $_SERVER['argv'][1] = null;
        $app  = new App();
        $app->run();
    }

    #[TestWith(['wrong'])]
    #[TestWith([123])]
    #[TestWith([PHP_EOL])]
    #[TestWith(['  '])]
    /**
     *
     * @return void
     * @throws Exception
     */
    public function testWrongArguments($argument)
    {
        $this->expectExceptionMessage('Укажите тип приложения - client или server');
        $_SERVER['argv'][1] = $argument;
        $app  = new App();
        $app->run();
    }

    #[TestWith(['server','createServerApp' ])]
    #[TestWith(['client','createClientApp' ])]
    /**
     * @param $arg
     * @param $methodCalled
     * @return void
     * @throws Exception
     */
    public function testCreateApp($arg, $methodCalled)
    {
        $_SERVER['argv'][1] = $arg;
        $app = $this->getMockBuilder(App::class)
            ->onlyMethods([$methodCalled])
            ->getMock();
        $app->expects(self::once())->method($methodCalled);
        $app->run();
    }
}
