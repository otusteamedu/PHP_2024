<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Currency extends Model
{
    use HasFactory;

    protected $table = 'currencies';

    public static function getTableName()
    {
        return with(new static)->getTable();
    }

    protected $fillable = [
        'code',
        'title',
        'type',
        'rate_to_usd'
    ];


    /**
     * Следует ли обрабатывать временные метки модели.
     *
     * @var bool
     */
    public $timestamps = false;
}
