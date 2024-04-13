<?php

declare(strict_types=1);

namespace Module\News\Infrastructure\Model;

use Illuminate\Database\Eloquent\Model;

/**
 * @property string $id
 * @property string $url
 * @property string $title
 * @property string $date
 */
final class NewsModel extends Model
{
    public $incrementing = false;
    public $timestamps = false;
    protected $table = 'news';
    protected $keyType = 'string';
    protected $primaryKey = 'id';
    protected $fillable = [
        'id',
        'url',
        'title',
        'date',
    ];
}
