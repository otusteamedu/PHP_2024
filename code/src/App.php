<?php

namespace SergeyShirykalov\YoutubeChannels;

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
            $storage = new ElasticSearchStorage();
            $manager = new ChannelManager($storage);
            $data = $_REQUEST['data'] ?? null;
            switch ($command) {
                case 'add':
                    $manager->add(json_decode($data, true, 512, JSON_THROW_ON_ERROR));
                    $message = 'Событие добавлено!';
                    break;
                case 'delete':
                    $manager->delete($data);
                    $message = 'Все события удалены!';
                    break;
                case 'channel_info':
                    $message = $manager->channelInfo($data);
                    break;
                case 'top':
                    $res = $manager->topChannels();
                    $message = !empty($res) ? 'Топ каналов по соотношению лайков/дизлайков: ' . json_encode($res) : 'Каналы не найдены!';
                    break;
                case '_storage_info': // служебная команда - информация об установленном Elasticsearch
                    $message = $manager->storageInfo();
                    break;
                case '_seed': // служебная команда - первоначальное заполнение тестовыми данными
                    $manager->seed();
                    $message = 'БД заполнена тестовыми данными!';
                    break;
                default:
                    $message = 'Неизвестная команда! (используйте add, delete, channel_info, top, _storage_info, _seed)';
            }
        }

        return Response::response($message);
    }
}
