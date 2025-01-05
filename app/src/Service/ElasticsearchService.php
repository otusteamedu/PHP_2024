<?php

declare(strict_types=1);

namespace App\Service;

use App\Entity\Product;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;

class ElasticsearchService implements SearchServiceInterface
{
    public function __construct(
        private readonly string $esIndex,
        private readonly ElasticsearchClientBuilderService $elasticsearchClientBuilderService,
        private readonly DenormalizerInterface&NormalizerInterface $serializer,
    ) {
    }

    public function search(array $params): ?array
    {
        foreach ($params as $key => $value) {
            $value = mb_strtolower($value);
            $query['bool']['must']['match'] = [$key => $value];
        }

        $params = [
            'index' => $this->esIndex,
            'body' => ['query' => $query],
        ];

        $client = $this->elasticsearchClientBuilderService->build();
        $arResponse = $client->search($params)->asArray();

        if (isset($arResponse['hits']['hits'])) {
            foreach ($arResponse['hits']['hits'] as $arItem) {
                $arProducts[] = $this->serializer->denormalize($arItem['_source'], Product::class, null, [ObjectNormalizer::DISABLE_TYPE_ENFORCEMENT => true]);
            }
        }

        return $arProducts ?? [];
    }
}
