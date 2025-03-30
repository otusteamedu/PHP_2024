<?php

namespace SergeyShirykalov\YoutubeChannels;

use Elastic\Elasticsearch\Client;
use Elastic\Elasticsearch\ClientBuilder;
use Elastic\Elasticsearch\Exception\AuthenticationException;
use Elastic\Elasticsearch\Exception\ClientResponseException;
use Elastic\Elasticsearch\Exception\MissingParameterException;
use Elastic\Elasticsearch\Exception\ServerResponseException;
use SergeyShirykalov\YoutubeChannels\DTO\ChannelSummaryResponse;
use SergeyShirykalov\YoutubeChannels\DTO\TopChannelItemDTO;
use SergeyShirykalov\YoutubeChannels\DTO\VideoAddRequest;
use SergeyShirykalov\YoutubeChannels\DTO\VideoAddResponse;
use SergeyShirykalov\YoutubeChannels\DTO\VideoDTO;
use SergeyShirykalov\YoutubeChannels\DTO\VideoFindByTitleRequest;
use SergeyShirykalov\YoutubeChannels\ElasticMappings;

class ElasticsearchStorage implements VideoStorageInterface
{
    private const string INDEX_NAME = 'youtube_channels';
    private Client $client;


    /**
     * @throws \Exception
     */
    public function __construct()
    {
        $this->client = ClientBuilder::create()
            ->setHosts(['elasticsearch:9200'])
            ->build();

        // проверяем, существует ли индекс, если нет, то создаем
        $indexExists = $this->client->indices()->exists(['index' => self::INDEX_NAME]);
        if (!$indexExists->asBool()) {
            $this->createIndex();
        }
    }


    /**
     * @param VideoAddRequest $videoAddRequest
     * @return VideoAddResponse
     */
    public function add(VideoAddRequest $videoAddRequest): VideoAddResponse
    {
        $response = $this->client->index([
                                             'index' => self::INDEX_NAME,
                                             'body' => json_encode($videoAddRequest->toArray())
                                         ]);

        return new VideoAddResponse($response->asArray()['_id']);
    }

    /**
     * @param string $videoId
     * @return void
     * @throws ClientResponseException
     * @throws MissingParameterException
     * @throws ServerResponseException
     */
    public function delete(string $videoId): void
    {
        $this->client->delete([
                                  'index' => self::INDEX_NAME,
                                  'id' => $videoId,
                              ]);
    }

    /**
     * @param string $videoId
     * @return VideoDTO
     * @throws ClientResponseException
     * @throws ServerResponseException
     */
    public function find(string $videoId): VideoDTO
    {
        $response = $this->client->search([
                                              'index' => self::INDEX_NAME,
                                              'body' => [
                                                  "query" => [
                                                      "ids" => [
                                                          "values" => [$videoId]
                                                      ]
                                                  ]
                                              ]
            ])->asArray();
        if ($response['hits']['total']['value'] === 0) {
            throw new ClientResponseException('Видео с таким именем не найдено');
        }
        return new VideoDTO(
            $response['hits']['hits'][0]['_id'],
            $response['hits']['hits'][0]['_source']['channel'],
            $response['hits']['hits'][0]['_source']['title'],
            $response['hits']['hits'][0]['_source']['release_date'],
            $response['hits']['hits'][0]['_source']['likes'],
            $response['hits']['hits'][0]['_source']['dislikes'],
        );
    }

    /**
     * @param VideoFindByTitleRequest $request
     * @return VideoDTO
     */
    public function findByTitle(VideoFindByTitleRequest $request): VideoDTO
    {
        $response = $this->client->search([
                                              'index' => self::INDEX_NAME,
                                              'body' => [
                                                  "query" => [
                                                      "term" => [
                                                          "title.keyword" => $request->getTitle()
                                                      ]
                                                  ]
                                              ]
                                          ])->asArray();
        if ($response['hits']['total']['value'] === 0) {
            throw new ClientResponseException('Видео с таким именем не найдено');
        }
        return new VideoDTO(
            $response['hits']['hits'][0]['_id'],
            $response['hits']['hits'][0]['_source']['channel'],
            $response['hits']['hits'][0]['_source']['title'],
            $response['hits']['hits'][0]['_source']['release_date'],
            $response['hits']['hits'][0]['_source']['likes'],
            $response['hits']['hits'][0]['_source']['dislikes'],
        );
    }

    /**
     * @param string $channel
     * @return ChannelSummaryResponse
     * @throws ClientResponseException
     * @throws ServerResponseException
     */
    public function channelSummary(string $channel): ChannelSummaryResponse
    {
        $response = $this->client->search([
                                              'index' => self::INDEX_NAME,
                                              'body' => [
                                                  "size" => 0,
                                                  "query" => [
                                                      "term" => [
                                                          "channel.keyword" => $channel
                                                      ]
                                                  ],
                                                  "aggs" => [
                                                      "channels" => [
                                                          "terms" => [
                                                              "field" => "channel.keyword"
                                                          ],
                                                          "aggs" => [
                                                              "sum_likes" => [
                                                                  "sum" => [
                                                                      "field" => "likes"
                                                                  ]
                                                              ],
                                                              "sum_dislikes" => [
                                                                  "sum" => [
                                                                      "field" => "dislikes"
                                                                  ]
                                                              ]
                                                          ]
                                                      ]
                                                  ]
                                              ]
                                          ])
            ->asArray();

        if ($response['hits']['total']['value'] === 0) {
            throw new ClientResponseException('Канал с таким именем не найден');
        }
        return new ChannelSummaryResponse(
            $channel,
            $response['aggregations']['channels']['buckets'][0]['sum_likes']['value'],
            $response['aggregations']['channels']['buckets'][0]['sum_dislikes']['value'],
        );
    }

    /**
     * @param int $limit
     * @return TopChannelItemDTO[]
     * @throws ClientResponseException
     * @throws ServerResponseException
     */
    public function topChannelsByRatio(int $limit): array
    {
        $response = $this->client->search([
                                              'index' => self::INDEX_NAME,
                                              'body' => [
                                                  "size" => 0,
                                                  "runtime_mappings" => [
                                                      "ratio" => [
                                                          "type" => "double",
                                                          "script" => [
                                                              "source" => "emit(1.0 * doc['likes'].value / doc['dislikes'].value)"
                                                          ]
                                                      ]
                                                  ],
                                                  "aggs" => [
                                                      "channels" => [
                                                          "terms" => [
                                                              "size" => $limit, /* кол-во каналов */
                                                              "field" => "channel.keyword",
                                                              "order" => [
                                                                  "likes_to_dislikes_ratio" => "desc"
                                                              ]
                                                          ],
                                                          "aggs" => [
                                                              "likes_to_dislikes_ratio" => [
                                                                  "avg" => [
                                                                      "field" => "ratio"
                                                                  ]
                                                              ]
                                                          ]
                                                      ]
                                                  ]
                                              ]
                                          ])
            ->asArray();

        return array_map(function ($item) {
            return new TopChannelItemDTO($item['key'], $item['likes_to_dislikes_ratio']['value']);
        }, $response['aggregations']['channels']['buckets']);
    }

    /**
     * @return void
     * @throws ClientResponseException
     * @throws ServerResponseException
     */
    public function seed(): void
    {
        $this->client->bulk([
                                'index' => self::INDEX_NAME,
                                'body' => file_get_contents(__DIR__ . "/seed_data.json"),
                            ]);
    }

    /**
     * @return string
     */
    public function storageInfo(): string
    {
        try {
            return $this->client->info();
        } catch (\Throwable $e) {
            return $e->getMessage();
        }
    }

    /**
     * Создать индекс с маппингом
     *
     * @return void
     * @throws ClientResponseException
     * @throws ServerResponseException
     * @throws MissingParameterException
     */
    private function createIndex(): void
    {
        $this->client->indices()->create([
                                             'index' => self::INDEX_NAME,
                                             'body' => [
                                                 'mappings' => ElasticMappings::getMappings(),
                                             ]
                                         ]);
    }
}
