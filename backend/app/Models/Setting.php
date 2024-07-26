<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    use HasFactory;

    protected $table ='settings';

    protected $fillable = [
        'cur_from_code',
        'cur_to_code',
        'profit'
    ];
}
