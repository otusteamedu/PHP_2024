<?php

declare(strict_types=1);

namespace Hukimato\App\Models\Posts;

use Closure;

class PostProxy
{
    public function __construct(
        public Closure|null $loadPosts,

        /** @var Post[] */
        public array   $posts,
    )
    {
    }
}