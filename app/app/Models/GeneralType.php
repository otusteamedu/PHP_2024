<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class GeneralType extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $keyType = 'string'; // Убедитесь, что это строка
    public $incrementing = false; // Отключаем автоинкремент для UUID

    public function courts()
    {
        return $this->hasMany(Court::class, 'general_type_id', 'id');
    }
}
