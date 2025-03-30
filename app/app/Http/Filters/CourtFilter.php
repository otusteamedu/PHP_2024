<?php

namespace App\Http\Filters;

use Illuminate\Database\Eloquent\Builder;

class CourtFilter extends AbstractFilter
{
    public const NAME = 'name';
    public const ADDRESS = 'address';
    public const CASS_REGION = 'cass_region';

    protected function getCallbacks(): array
    {
        return [
            self::NAME => [$this, 'name'],
            self::ADDRESS => [$this, 'address'],
            self::CASS_REGION => [$this, 'cass_region'],
        ];
    }

    public function name(Builder $builder, $value)
    {
        $builder->where('name', 'ILIKE', "%{$value}%");
    }

    public function address(Builder $builder, $value)
    {
        $builder->where('address', 'ILIKE', "%{$value}%");
    }

    public function cass_region(Builder $builder, $value)
    {
        $builder->where('cass_region', $value);
    }
}
