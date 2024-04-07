<?php

declare(strict_types=1);

namespace AlexanderPogorelov\ElasticSearch\Service;

use AlexanderPogorelov\ElasticSearch\Dto\SearchDto;
use AlexanderPogorelov\ElasticSearch\Validator\PromptValidator;

readonly class PromptService
{
    public function __construct(private PromptValidator $validator)
    {
    }

    public function readInput(): SearchDto
    {
        $searchData = [];
        $searchData['query'] = readline('Введите поисковый запрос: ');
        $searchData['category'] = readline('Введите категорию товара: ');
        $searchData['minPrice'] = readline('Введите минимальную цену товара: ');
        $searchData['maxPrice'] = readline('Введите максимальную цену товара: ');
        $searchData['quantity'] = readline('Введите минимальное количество товара на складе: ');

        $this->validator->validate($searchData);

        return SearchDto::createFromSearchData($searchData);
    }
}
