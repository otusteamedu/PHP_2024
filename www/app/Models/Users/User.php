<?php

declare(strict_types=1);

namespace Hukimato\App\Models\Events;

use Hukimato\App\Models\DataMapper\ManyToMany;
use Hukimato\App\Models\DataMapper\OneToMany;
use Hukimato\App\Models\DataMapper\PrimaryKey;

class User
{
    #[PrimaryKey]
    private string $username;

    #[ManyToMany(
        relationName: 'user_to_followers',
        localKey: ''
    )]
    private User $followers;

    /** @var User[] $children */
    private array $posts;

    /** @var User[] $children */
    #[ManyToMany(relationName: 'user_to_children', localKey: 'id')]
    private array $children;

    public function __construct(
        int $id,
        string $firstName,
        string $lastName,
        string $email,

    )
    {
        $this->priority = $rawParams['priority'] ?? 0;
        $this->eventName = $rawParams['eventName'] ?? '';
        $this->params = $rawParams['params'] ?? [];
    }
}
