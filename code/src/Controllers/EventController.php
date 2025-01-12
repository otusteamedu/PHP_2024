<?php

declare(strict_types=1);

namespace Asyrovatkin\Hw11\Controllers;

use Asyrovatkin\Hw11\Builders\EventBuilder;
use Asyrovatkin\Hw11\Helpers\InputFormatterToJson;
use Asyrovatkin\Hw11\Repositories\EventRepository;


class EventController
{
    private EventRepository $eventRepository;
    private InputFormatterToJson $inputFormatterToJson;

    public function __construct()
    {
        $this->eventRepository = new EventRepository();
        $this->inputFormatterToJson = new InputFormatterToJson();
    }

    public function putEvent()
    {
        $inputEvents = $_POST['data'];

        try {
            $eventsArr = $this->inputFormatterToJson->format($inputEvents);
        } catch (\Exception $e) {
            $this->inputError($e->getMessage());
            die();
        }

        $eventBuilder = new EventBuilder();
        foreach ($eventsArr as $eventArr) {
            $event = $eventBuilder->build($eventArr);
            $this->eventRepository->addEvent($event);
        }

        print 'Данные успешно добавлены <br><br>';
        print '<a href="http://mysite.local/"> Добавить данные </a> <br><br>';
        print '<a href="http://mysite.local/clear"> Очистить хранилище </a> <br><br>';
        print '<a href="http://mysite.local/search"> Перейти к поиску </a> <br><br>';
    }

    private function inputError(string $errorMessage)
    {
        print $errorMessage;

    }

    public function getEventIdsByParamsWithMaxPriority()
    {
        $params = [];
        if ($_POST['param1'] != '') $params['param1'] = intval($_POST['param1']);
        if ($_POST['param2'] != '') $params['param2'] = intval($_POST['param2']);

        if (empty($params)) {
            print 'Пустой запрос! <br><br>';

        } else {
            $eventsNames = $this->eventRepository->getEventIdsByParamsWithMaxPriority($params);

            if (empty($eventsNames)) {
                print 'Ничего не найдено <br><br>';
            } else {
                print 'Найденные события <br><br>';
                foreach ($eventsNames as $eventName) {
                    print $eventName . '<br><br>';
                }
            }
        }

        print '<a href="http://mysite.local/search"> Перейти к поиску </a> <br><br>';
        print '<a href="http://mysite.local/"> Добавить данные </a> <br><br>';
        print '<a href="http://mysite.local/clear"> Очистить хранилище </a> <br><br>';
    }

    public function clearStorage()
    {
        $this->eventRepository->clearStorage();
        print 'Хранилище очищено <br><br>';
        print '<a href="http://mysite.local/"> Перейти к добавлению данных</a> <br><br>';
    }

}