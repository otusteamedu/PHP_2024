<?php

namespace App\Infrastructure\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lead extends Model
{
    use HasFactory;
    protected $guarded = ['created_at', 'updated_at'];

    protected static function newFactory()
    {
        return \Database\Factories\LeadFactory::new();
    }

}
