<?php

declare(strict_types=1);

namespace Hukimato\App\Models\Posts;

use Closure;
use Hukimato\App\Models\Users\User;

class Post
{
    public function __construct(
        public string               $title,
        public string               $content,
        protected User|Closure|null $user = null,
        public ?int                 $id = null,
    )
    {
    }

    public function getUser(): User|Closure
    {
        if ($this->user instanceof Closure) {
            $this->user = ($this->user)();
        }
        return $this->user;
    }

    public function setUser(User|Closure $user): Post
    {
        $this->user = $user;
        return $this;
    }


}
