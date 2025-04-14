<?php
namespace App\Observers;

use App\Models\Youtubechannel;
use Elastic\Elasticsearch\Client;

class YoutubechannelsObserver
{
    private Client $elasticsearch;

    public function __construct(Client $elasticsearch)
    {
        $this->elasticsearch = $elasticsearch;
    }

    public function saved(Youtubechannel $model)
    {
        $this->elasticsearch->index(
            array_merge($this->generateElasticSearchParams($model), [
                'body' => $model->toSearchArray(),
            ]));
    }

    public function deleted()
    {
        foreach (Youtubechannel::cursor() as $youtubechannel)
        {
            $this->elasticsearch->delete([
                'index' => $youtubechannel->getSearchIndex(),
                'id' => $youtubechannel->getKey(),
            ]);
        }
    }

    private function generateElasticSearchParams(Youtubechannel $model): array
    {
        return [
            'index' => $model->getSearchIndex(),
            'type' => $model->getSearchType(),
            'id' => $model->getKey(),
        ];
    }

    public function reindex()
    {
        foreach (Youtubechannel::cursor() as $youtubechannel)
        {
            $this->elasticsearch->index([
                'index' => $youtubechannel->getSearchIndex(),
                'type' => $youtubechannel->getSearchType(),
                'id' => $youtubechannel->getKey(),
                'body' => $youtubechannel->toSearchArray(),
            ]);
        }
    }
}
