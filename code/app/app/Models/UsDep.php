<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UsDep extends Model
{
    protected $fillable = [
        'user_id',
        'department_id',
    ];
}
