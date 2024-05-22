<?php

declare(strict_types=1);

namespace App\Infrastructure\Entity;

use Doctrine\ORM\Mapping\Builder\ClassMetadataBuilder;
use Doctrine\ORM\Mapping\ClassMetadata;

class Category extends \App\Domain\Category\Category
{
    public static function loadMetadata(ClassMetadata $metadata)
    {
        $builder = new ClassMetadataBuilder($metadata);

        $builder
            ->createField('id', 'integer')
            ->makePrimaryKey()
            ->generatedValue()
            ->build();

        $builder
            ->addField('title','string');

        $builder
            ->addField('subscribers', 'json');
    }
}