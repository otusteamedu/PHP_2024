<?php

namespace App\Models;

use App\Models\Traits\HasSearch;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $name
 * @property string $url
 * @property array $videos
 * @property int $totalLike
 * @property int $totaldislikes
 */

class Youtubechannel extends Model
{
    use HasFactory;
    use HasSearch;

    public $casts = [
        'videos' => 'array',
    ];
}
