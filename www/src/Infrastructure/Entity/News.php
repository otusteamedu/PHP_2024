<?php

declare(strict_types=1);

namespace App\Infrastructure\Entity;

use App\Domain\Category\Category;
use App\Domain\State\AbstractState;
use App\Domain\State\ConcreteStates\Draft;
use App\Domain\User\User;
use DateTime;
use Doctrine\ORM\Mapping\Builder\ClassMetadataBuilder;
use Doctrine\ORM\Mapping\ClassMetadata;

class News extends \App\Domain\News\News
{
    private $state_num;

    public function __construct(
        ?int $id,
        string $title,
        User $author,
        DateTime $createdAt,
        Category $category,
        string $body,
        AbstractState $state = new Draft())
    {
        parent::__construct($id, $title, $author, $createdAt, $category, $body, $state);
        $this->state_num = $this->state::getScalarFromState($this->state);
    }


    public static function loadMetadata(ClassMetadata $metadata)
    {
        $builder = new ClassMetadataBuilder($metadata);

        $builder
            ->createField('id', 'integer')
            ->makePrimaryKey()
            ->generatedValue()
            ->build();

        $builder
            ->addField('title', 'string')
            ->addField('createdAt', 'datetime')
            ->addField('body', 'string')
            ->addField('state_num', 'integer');

        $builder
            ->addManyToOne('category', Category::class);

        $builder
            ->createManyToOne('author', User::class)
            ->addJoinColumn('author', 'username')
            ->build();

    }
}