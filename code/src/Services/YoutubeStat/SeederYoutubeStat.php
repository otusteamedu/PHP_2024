<?php

declare(strict_types=1);

namespace Asyrovatkin\Hw10\Services\YoutubeStat;

use Asyrovatkin\Hw10\Classes\Elastic;
use Asyrovatkin\Hw10\Models\YoutubeStatRecord;
use Elastic\Elasticsearch\Exception\ClientResponseException;
use Elastic\Elasticsearch\Exception\MissingParameterException;
use Elastic\Elasticsearch\Exception\ServerResponseException;

class SeederYoutubeStat
{
    const INDEX_NAME = 'y-stat';

    private const KEY_SPACE = 'abcdefghi';

    const MAPPINGS = [
        'mappings' => [
            'properties' => [
                'channel_title' => [
                    'type' => 'keyword'
                ],
                'channel_url' => [
                    'type' => 'keyword'
                ],
                'author' => [
                    'type' => 'text'
                ],
                'video_title' => [
                    'type' => 'text'
                ],
                'video_url' => [
                    'type' => 'keyword'
                ],
                'views' => [
                    'type' => 'integer'
                ],
                'category' => [
                    'type' => 'keyword'
                ],
                'likes' => [
                    'type' => 'integer'
                ],
                'dislikes' => [
                    'type' => 'integer'
                ]
            ]
        ]
    ];


    /**
     * @throws ClientResponseException
     * @throws ServerResponseException
     * @throws MissingParameterException
     */
    public function seed($length = 10_000): void
    {
        $defaultLength = 10_000;
        $length = $length ? intval($length) : $defaultLength;
        $elastic = new Elastic(self::INDEX_NAME);
        $elastic->createIndex(1, self::MAPPINGS);
        $elastic->addBatch($this->getRandomData($length));
        print 'Добавлено ' . $length . ' документов' . '<br>';
        if ($length === $defaultLength) {
            print 'Можно изменить добавив в uri к-во например /seed/20000';
        }
    }

    /**
     * @param int $length
     * @return array
     */
    private function getRandomData(int $length): array
    {
        $data = [];
        for ($i = 0; $i < $length; $i++) {
            $data[] = [
                'index' => [
                    '_id' => $i
                ]
            ];
            $data[] = $this->getRandomRow();
        }
        return $data;
    }

    /**
     * @param int $length
     * @return string
     */
    private function getRandomString(int $length = 10): string
    {
        $permitted_chars = self::KEY_SPACE;
        return substr(str_shuffle($permitted_chars), 0, $length);
    }

    private function getRandomRow(): array
    {
        $youtubeStatRecord = new YoutubeStatRecord();
        $youtubeStatRecord->setChannelTitle('Chanel' . $this->getRandomString(3));
        $youtubeStatRecord->setChannelUrl('https://www.youtube.com/@' . $this->getRandomString());
        $youtubeStatRecord->setAuthor($this->getRandomString(5) . ' ' . $this->getRandomString(8));
        $youtubeStatRecord->setVideoTitle($this->getRandomString() . ' ' . $this->getRandomString() . ' ' . $this->getRandomString());
        $youtubeStatRecord->setVideoUrl('https://www.youtube.com/watch?v=' . $this->getRandomString());
        $youtubeStatRecord->setViews(random_int(0, 10_000));
        $youtubeStatRecord->setCategory($this->getRandomString(4));
        $youtubeStatRecord->setLikes(random_int(0, 10_000));
        $youtubeStatRecord->setDislikes(random_int(0, 10_000));

        return $youtubeStatRecord->toArray();
    }
}