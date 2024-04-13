<?php

declare(strict_types=1);

namespace Hukimato\App\Models\Users;

use Closure;
use Hukimato\App\Models\Posts\Post;

class User
{

    public function __construct(
        public string           $username,

        public string           $email,

        /** @var Post[] $posts */
        protected array|Closure $posts = [],

        /** @var User[] $friends */
        protected array|Closure $friends = [],
    )
    {

    }

    public function getFriends(): array
    {
        if ($this->friends instanceof Closure) {
            $this->friends = ($this->friends)();
        }
        return $this->friends;
    }

    public function setFriends(array $friends): User
    {
        $this->friends = $friends;
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
