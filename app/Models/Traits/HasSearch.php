<?php

namespace App\Models\Traits;

use App\Observers\YoutubechannelsObserver;
use Illuminate\Database\Eloquent\Model;

/**
 * Trait HasSearch
 * @package App\Models\Traits
 * @mixin Model
 */
trait HasSearch
{
    public static function bootSearchable()
    {
        if (config('services.search.enabled')){
            static::observe(YoutubechannelsObserver::class);
        }
    }
    public function getSearchIndex(): string
    {
        return $this->getTable() . '_index';
    }

    public function getSearchType(): string
    {
        if (property_exists($this, 'useSearchType')) {
            return $this->useSearchType;
        }
        return $this->getTable() . '_index';
    }

    public function toSearchArray(): array
    {
        return $this->toArray();
    }
}
