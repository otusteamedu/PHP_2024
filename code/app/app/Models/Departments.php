<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Departments extends Model
{
    protected $fillable = [
        'name',
        'sort',
        'parent_department_id',
        'head_user_id'
    ];
}
