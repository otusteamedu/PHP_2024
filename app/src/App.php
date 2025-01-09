<?php

declare(strict_types=1);

namespace AnatolyShilyaev\App;

use AnatolyShilyaev\App\Elastic\Connection;
use AnatolyShilyaev\App\Elastic\IndexHandler;
use AnatolyShilyaev\App\Elastic\DataHandler;
use AnatolyShilyaev\App\Elastic\YouTubeStatistics;

class App
{
    private Connection $elastic;
    private $channel_id;

    public function __construct()
    {
        $this->elastic = new Connection();
        $this->channel_id = 'UC12345679';
    }

    public function run(): void
    {

        $action = $_POST['action'] ?? '';

        switch ($_POST['method']) {
            case 'CREATE_INDEX':
                $this->createIndex($action);
                break;
            case 'DELETE_INDEX':
                $this->deleteIndex($action);
                break;
            case 'ADD':
                switch ($action) {
                    case 'channel':
                        $this->addChanel();
                        break;
                    case 'video':
                        $this->addVideo();
                        break;

                    default:
                        break;
                }
                break;
            case 'DELETE':
                switch ($action) {
                    case 'channel':
                        $this->deleteChanel();
                        break;
                    case 'video':
                        $this->deleteVideo();
                        break;

                    default:
                        break;
                }
                break;
            case 'SHOW':
                switch ($action) {
                    case 'show_index':
                        $response = $this->elastic->client->cat()->indices(['v' => true]);
                        echo "<pre>";
                        echo ($response) . '<br><br>';
                        echo "</pre>";
                        break;
                    case 'show_chanels':
                        $response = (new DataHandler($this->elastic))->getAllDocuments('youtube_channels');
                        echo "<h1>Каналы</h1>";
                        echo "<table>";
                        echo "    <thead>";
                        echo "        <tr>";
                        echo "            <th>ID</th>";
                        echo "            <th>Название канала</th>";
                        echo "            <th>Описание</th>";
                        echo "            <th>Подписчики</th>";
                        echo "            <th>Дата создания</th>";
                        echo "            <th>Количество видео</th>";
                        echo "            <th>Количество просмотров</th>";
                        echo "        </tr>";
                        echo "    </thead>";
                        echo "    <tbody>";

                        if (!empty($response)) {
                            foreach ($response as $doc) {
                                echo "<tr>";
                                echo "<td>" . htmlspecialchars($doc['_id']) . "</td>";
                                echo "<td>" . htmlspecialchars($doc['_source']['channel_name'] ?? 'Нет данных') . "</td>";
                                echo "<td>" . htmlspecialchars($doc['_source']['description'] ?? 'Нет описания') . "</td>";
                                echo "<td>" . number_format($doc['_source']['subscriber_count'] ?? 0) . "</td>";
                                echo "<td>" . htmlspecialchars($doc['_source']['creation_date'] ?? '-') . "</td>";
                                echo "<td>" . number_format($doc['_source']['total_videos'] ?? 0) . "</td>";
                                echo "<td>" . number_format($doc['_source']['total_views'] ?? 0) . "</td>";
                                echo "</tr>";
                            }
                        } else {
                            echo "<tr>";
                            echo "<td colspan='5'>Данные не найдены.</td>";
                            echo "</tr>";
                        }

                        echo "    </tbody>";
                        echo "</table>";
                        break;
                    case 'show_videos':
                        $response = (new DataHandler($this->elastic))->getAllDocuments('youtube_videos');
                        echo "<h1>Видео</h1>";
                        echo "<table>";
                        echo "    <thead>";
                        echo "        <tr>";
                        echo "            <th>ID</th>";
                        echo "            <th>ID канала</th>";
                        echo "            <th>Название видео</th>";
                        echo "            <th>Описание</th>";
                        echo "            <th>Количество просмотров</th>";
                        echo "            <th>Дата создания</th>";
                        echo "            <th>Количество лайков</th>";
                        echo "            <th>Количество дизлайков</th>";
                        echo "            <th>Количество комментариев</th>";
                        echo "        </tr>";
                        echo "    </thead>";
                        echo "    <tbody>";

                        if (!empty($response)) {
                            foreach ($response as $doc) {
                                echo "<tr>";
                                echo "<td>" . htmlspecialchars($doc['_id']) . "</td>";
                                echo "<td>" . htmlspecialchars($doc['_source']['channel_id'] ?? 'Нет данных') . "</td>";
                                echo "<td>" . htmlspecialchars($doc['_source']['video_title'] ?? 'Нет данных') . "</td>";
                                echo "<td>" . htmlspecialchars($doc['_source']['description'] ?? 'Нет описания') . "</td>";
                                echo "<td>" . number_format($doc['_source']['view_count'] ?? 0) . "</td>";
                                echo "<td>" . htmlspecialchars($doc['_source']['publish_date'] ?? '-') . "</td>";
                                echo "<td>" . number_format($doc['_source']['like_count'] ?? 0) . "</td>";
                                echo "<td>" . number_format($doc['_source']['dislike_count'] ?? 0) . "</td>";
                                echo "<td>" . number_format($doc['_source']['comment_count'] ?? 0) . "</td>";
                                echo "</tr>";
                            }
                        } else {
                            echo "<tr>";
                            echo "<td colspan='5'>Данные не найдены.</td>";
                            echo "</tr>";
                        }

                        echo "    </tbody>";
                        echo "</table>";
                        break;

                    default:
                        break;
                }


                break;
            case 'GET':
                switch ($action) {
                    case 'likes_count':
                        $response = $this->getTotalLikesDislikes();

                        echo "<h1>Лайки / Дизлайки</h1>";
                        echo "<table>";
                        echo "    <thead>";
                        echo "        <tr>";
                        echo "            <th width=150px>ID канала</th>";
                        echo "            <th width=150px>Количество лайков</th>";
                        echo "            <th width=150px>Количество дизлайков</th>";
                        echo "        </tr>";
                        echo "    </thead>";
                        echo "    <tbody>";
                        echo "      <tr>";
                        echo "      <td>" . $response['channel_id'] . "</td>";
                        echo "      <td>" . $response['total_likes'] . "</td>";
                        echo "      <td>" . $response['total_dislikes'] . "</td>";
                        echo "      </tr>";
                        echo "    </tbody>";
                        echo "</table>";
                        break;
                    case 'top_video':
                        $response = $this->getTopChannelsByLikeRatio()[0];

                        echo "<h1>Лайки / Дизлайки</h1>";
                        echo "<table>";
                        echo "    <thead>";
                        echo "        <tr>";
                        echo "            <th width=150px>ID канала</th>";
                        echo "            <th width=150px>Количество лайков</th>";
                        echo "            <th width=150px>Количество дизлайков</th>";
                        echo "            <th width=150px>Соотношение</th>";
                        echo "        </tr>";
                        echo "    </thead>";
                        echo "    <tbody>";
                        echo "      <tr>";
                        echo "      <td>" . $response['channel_id'] . "</td>";
                        echo "      <td>" . $response['total_likes'] . "</td>";
                        echo "      <td>" . $response['total_dislikes'] . "</td>";
                        echo "      <td>" . $response['like_ratio'] . "</td>";
                        echo "      </tr>";
                        echo "    </tbody>";
                        echo "</table>";
                        break;

                    default:

                        break;
                }
                break;
            default:
                echo "Ошибка: Метод не поддерживается.";
                break;
        }
    }

    private function createIndex($index_type): void
    {
        (new IndexHandler($this->elastic, $index_type))->createIndex();
    }

    private function deleteIndex($index_type): void
    {
        (new IndexHandler($this->elastic, $index_type))->deleteIndex();
    }

    private function addChanel(): void
    {
        $channelData = [
            'channel_id' => $this->channel_id,
            'channel_name' => 'Tech Review',
            'description' => 'Обзоры техники и гаджетов',
            'creation_date' => '2018-06-15',
            'subscriber_count' => 500000,
            'total_videos' => 250,
            'total_views' => 20000000,
            'country' => 'RU',
            'tags' => ['технологии', 'обзоры', 'гаджеты']
        ];
        (new DataHandler($this->elastic))->addChannel($channelData);
    }

    private function addVideo(): void
    {
        $videoData = [
            'video_id' => 'vid' . (rand(1, 100000)),
            'channel_id' => $this->channel_id,
            'video_title' => 'Лучшие смартфоны 2024 года',
            'description' => 'Обзор топ смартфонов этого года.',
            'publish_date' => '2024-03-10',
            'view_count' => 150000,
            'like_count' => rand(1, 153000),
            'dislike_count' => rand(1, 3000),
            'comment_count' => 500,
            'duration_seconds' => 900,
            'tags' => ['смартфоны', 'обзор', 'технологии'],
            'category' => 'Технологии'
        ];
        (new DataHandler($this->elastic))->addVideo($videoData);
    }

    private function deleteChanel(): void
    {
        $channel_id = $this->channel_id;
        (new DataHandler($this->elastic))->deleteChannel($channel_id);
    }
    private function deleteVideo(): void
    {
        $video_id = 'vid123456';
        (new DataHandler($this->elastic))->deleteVideo($video_id);
    }

    private function getTotalLikesDislikes(): array
    {
        $channel_id = $this->channel_id;
        return (new YouTubeStatistics($this->elastic))->getTotalLikesDislikes($channel_id);
    }

    private function getTopChannelsByLikeRatio(): array
    {
        return (new YouTubeStatistics($this->elastic))->getTopChannelsByLikeRatio();
    }
}
