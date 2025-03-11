<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class News extends Model
{
    protected $table = 'news';

    protected $fillable = ['name', 'url', 'created_at'];

    public $timestamps = false;

    protected $casts = [
        'created_at' => 'date',
    ];
}
