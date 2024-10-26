<?php

declare(strict_types=1);

namespace App\Blog\Model;

enum PostStatus: string
{
    case DRAFT = 'draft';
    case PUBLISHED = 'published';
    case ARCHIVED = 'archived';
}
