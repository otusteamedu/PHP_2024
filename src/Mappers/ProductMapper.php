<?php

namespace Amikha1lov\DataMapper\Mappers;

use Amikha1lov\DataMapper\Entities\Product;

class ProductMapper extends DataMapper
{
    protected function getTableName(): string
    {
        return 'product';
    }

    protected function getColumns(): array
    {
        return [
            'id',
            'title',
            'price'
        ];
    }

    protected function instantiate(array $data): ?Product
    {
        return new Product(
            $data['id'],
            $data['title'],
            $data['price']
        );
    }
}
