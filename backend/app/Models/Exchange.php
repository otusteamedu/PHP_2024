<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Exchange extends Model
{
    use HasFactory;

    protected $table = 'exchanges';

    public static function getTableName()
    {
        return with(new static)->getTable();
    }

    protected $fillable = [
        'cur_from_code',
        'cur_to_code',
        'profit',
        'status',
    ];
}
