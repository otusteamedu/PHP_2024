<?php

declare(strict_types=1);

namespace Hukimato\App\Models\Users;

use Closure;
use Hukimato\App\Models\DataMapper\ManyToMany;
use Hukimato\App\Models\DataMapper\OneToMany;
use Hukimato\App\Models\DataMapper\PrimaryKey;
use Hukimato\App\Models\Posts\Post;

class User
{
    #[PrimaryKey]
    #[Property]
    public string $username;

    #[PrimaryKey]
    public string $id;


    #[OneToMany(
        modelName: Post::class,
        localKey: 'username',
        foreignKey: 'user_username',
    )]
    /** @var Post[] $posts */
    protected array|Closure $posts;


    #[ManyToMany(
        modelName: User::class,
        relationName: 'user_to_followers',
        localKey: 'username',
        foreignKey: 'user_username'
    )]
    /** @var User[] $followers */
    protected array|Closure $followers;


    public function __construct(
        string $username,
        array|Closure  $followers,
        array|Closure  $posts,

    )
    {
        $this->username = $username;
        $this->followers = $followers;
        $this->posts = $posts;
    }

    public function getFollowers(): array
    {
        if ($this->followers instanceof Closure) {
            $this->followers = ($this->followers)();
        }
        return $this->followers;
    }

    public function setFollowers(array $followers): User
    {
        $this->followers = $followers;
        return $this;
    }

    public function getPosts(): array
    {
        if ($this->posts instanceof Closure) {
            $this->posts = ($this->posts)();
        }
        return $this->posts;
    }

    public function setPosts(array $posts): User
    {
        $this->posts = $posts;
        return $this;
    }
}
