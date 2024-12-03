<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Users extends Model
{
    protected $fillable = [
        'uuid',
        'name',
        'last_name',
        'second_name',
        'full_name',
        'email',
        'direction',
        'post',
        'birthday',
        'city',
        'phone',
        'work_phone',
        'personal_phone',
        'photo',
    ];
}
