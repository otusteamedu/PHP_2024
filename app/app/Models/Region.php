<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Region extends Model
{
    use SoftDeletes;

    protected $guarded = [];
    protected $keyType = 'string'; // Убедитесь, что это строка
    public $incrementing = false; // Отключаем автоинкремент для UUID

    public function courts()
    {
        return $this->hasMany(Court::class, 'region_id', 'id');
    }
}
