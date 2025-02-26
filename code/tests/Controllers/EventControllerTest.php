<?php

declare(strict_types=1);

namespace Asyrovatkin\Hw11\tests\Controllers;

use Asyrovatkin\Hw11\Builders\EventBuilder;
use Asyrovatkin\Hw11\Controllers\EventController;
use Asyrovatkin\Hw11\Helpers\InputFormatterToJson;
use Asyrovatkin\Hw11\Repositories\EventRepository;
use PHPUnit\Framework\TestCase;


class EventControllerTest extends TestCase
{
    public function testPutEvent()
    {
        $_POST['data'] = $this->getPostData();
        $eventRepository = $this->getMockBuilder(EventRepository::class)->disableOriginalConstructor()->getMock();
        $inputFormatterToJson = $this->getMockBuilder(InputFormatterToJson::class)->getMock();
        $eventBuilder = $this->getMockBuilder(EventBuilder::class)->getMock();

        $eventController = new EventController($eventRepository, $inputFormatterToJson, $eventBuilder);

        $string = 'Данные успешно добавлены <br><br>'
        . '<a href="http://mysite.local/"> Добавить данные </a> <br><br>'
        . '<a href="http://mysite.local/clear"> Очистить хранилище </a> <br><br>'
        . '<a href="http://mysite.local/search"> Перейти к поиску </a> <br><br>';

        $this->expectOutputString($string);
        $eventController->putEvent();
    }

    /**
     * @dataProvider getEventIdsByParamsWithMaxPriorityDataProvider
     * @param string $param1
     * @param string $param2
     * @param string $expectedMessage
     * @param array $expectedResult
     * @return void
     */
    public function testGetEventIdsByParamsWithMaxPriority(
        string $param1,
        string $param2,
        string $expectedMessage,
        array $expectedResult
    )
    {
        $_POST['param1'] = $param1;
        $_POST['param2'] = $param2;

        $inputFormatterToJson = $this->getMockBuilder(InputFormatterToJson::class)->getMock();
        $eventBuilder = $this->getMockBuilder(EventBuilder::class)->getMock();
        $eventRepository = $this->getMockBuilder(EventRepository::class)->disableOriginalConstructor()->getMock();
        $eventRepository->expects($this->any())->method('getEventIdsByParamsWithMaxPriority')->willReturn($expectedResult);

        $eventController = new EventController($eventRepository, $inputFormatterToJson, $eventBuilder);

        $menuText = '<a href="http://mysite.local/search"> Перейти к поиску </a> <br><br>'
        . '<a href="http://mysite.local/"> Добавить данные </a> <br><br>'
        . '<a href="http://mysite.local/clear"> Очистить хранилище </a> <br><br>';

        $this->expectOutputString($expectedMessage . $menuText);
        $eventController->getEventIdsByParamsWithMaxPriority();


    }

    public function testClearStorage()
    {
        $_POST['data'] = $this->getPostData();
        $eventRepository = $this->getMockBuilder(EventRepository::class)->disableOriginalConstructor()->getMock();
        $inputFormatterToJson = $this->getMockBuilder(InputFormatterToJson::class)->getMock();
        $eventBuilder = $this->getMockBuilder(EventBuilder::class)->getMock();

        $eventController = new EventController($eventRepository, $inputFormatterToJson, $eventBuilder);

        $string = 'Хранилище очищено <br><br>'
        . '<a href="http://mysite.local/"> Перейти к добавлению данных</a> <br><br>';

        $this->expectOutputString($string);
        $eventController->clearStorage();
    }

    private function getPostData(): string
    {
        return '{
    priority: 1000,
    conditions: {
        param1 = 1
    },
    event: {
        ::event::
    },
},
{
    priority: 2000,
    conditions: {
        param1 = 2,
        param2 = 2
    },
    event: {
        ::event::
    },
},
{
    priority: 3000,
    conditions: {
        param1 = 1,
        param2 = 2
    },
    event: {
        ::event::
    },
},';
    }

    public static function getEventIdsByParamsWithMaxPriorityDataProvider(): array
    {
        return [
            ['', '', 'Пустой запрос! <br><br>', []],
            ['1', '', 'Ничего не найдено <br><br>', []],
            ['', '1', 'Ничего не найдено <br><br>', []],
            ['1', '2', 'Ничего не найдено <br><br>', []],
            ['1', '2', 'Найденные события <br><br>1<br><br>2<br><br>3<br><br>', [1, 2, 3]],
        ];
    }
}