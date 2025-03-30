<?php

namespace SergeyShirykalov\YoutubeChannels;

use SergeyShirykalov\YoutubeChannels\DTO\VideoAddRequest;

class App
{
    private static ?string $command;
    private static ?array $data;

    /**
     * @throws \JsonException
     */
    public static function run(): string
    {
        self::$command = $_REQUEST['command'] ?? null;
        if (empty(self::$command)) {
            return Response::response('Необходимо указать параметр command!', 400);
        } else {
            $data = $_REQUEST['data'] ?? null;
            if (!is_null($data)) {
                self::$data = json_decode($data, true, 512, JSON_THROW_ON_ERROR);
            }
            $storage = new ElasticsearchStorage();
            $manager = new VideoManager($storage);
            return self::handle($manager);
        }
    }

    private static function handle(VideoManager $manager): string
    {
        switch (self::$command) {
            case 'add':
                $response = $manager->add(VideoAddRequest::fromArray(self::$data));
                $message = ['id' => $response->getId()];
                break;
            case 'delete':
                try {
                    $manager->delete(self::$data['id']);
                    $message = ['message' => 'Видео удалено!'];
                } catch (\Exception $e) {
                    $message = ['message' => $e->getMessage()];
                }
                break;
            case 'channel_summary':
                try {
                    $response = $manager->channelSummary(self::$data['channel']);
                    $message = $response->toArray();
                } catch (\Exception $e) {
                    $message = ['message' => $e->getMessage()];
                }
                break;
            case 'top_channels':
                $res = $manager->topChannelsByRatio(self::$data['limit'] ?? 10);
                if (!empty($res)) {
                    $res = array_map(static fn ($item) => $item->toArray(), $res);
                    $message = $res;
                } else {
                    $message = ['message' => 'Каналы не найдены!'];
                }
                break;
            case '_storage_info': // служебная команда - информация об установленном Elasticsearch
                $message = json_decode($manager->storageInfo(), true);
                break;
            case '_seed': // служебная команда - первоначальное заполнение тестовыми данными
                $manager->seed();
                $message = ['message' => 'БД заполнена тестовыми данными!'];
                break;
            default:
                $message = ['message' => 'Неизвестная команда! (используйте add, delete, channel_summary, top_channels, _storage_info, _seed)'];
        }
        return JsonResponse::response($message);
    }
}
