<?php

namespace SergeyShirykalov\RedisEvents;

class App
{
    /**
     * @throws \JsonException
     */
    public static function run(): string
    {
        $command = $_REQUEST['command'] ?? null;
        if (empty($command)) {
            return Response::response('Необходимо указать параметр command!', 400);
        } else {
            $storage  = new RedisStorage();
            $manager = new EventManager($storage);
            $data = $_REQUEST['data'] ?? null;
            switch ($command) {
                case 'add':
                    $manager->add(json_decode($data, true, 512, JSON_THROW_ON_ERROR));
                    $message = 'Событие добавлено!';
                    break;
                case 'clear':
                    $manager->clear();
                    $message = 'Все события удалены!';
                    break;
                case 'get':
                    $res = $manager->get(json_decode($data, true, 512, JSON_THROW_ON_ERROR)['params'] ?? []);
                    $message = !empty($res) ? 'Найдено событие: ' . json_encode($res) : 'Событие не найдено!';
                    break;
                default:
                    $message = 'Неизвестная команда! (используйте add, get, clear)';
            }
        }

        return Response::response($message);
    }
}
