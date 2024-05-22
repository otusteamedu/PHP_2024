<?php

declare(strict_types=1);

namespace App\Infrastructure\Entity;

use Doctrine\ORM\Mapping\Builder\ClassMetadataBuilder;
use Doctrine\ORM\Mapping\ClassMetadata;

class User extends \App\Domain\User\User
{
    public static function loadMetadata(ClassMetadata $metadata)
    {
        $builder = new ClassMetadataBuilder($metadata);

        $builder->setTable('users');

        $builder
            ->createField('username', 'string')
            ->makePrimaryKey()
            ->build();

        $builder
            ->addField('news', 'json');
    }
}