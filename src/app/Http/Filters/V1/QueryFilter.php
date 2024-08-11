<?php

namespace App\Http\Filters\V1;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder;

abstract class QueryFilter
{

    /**
     * @param Builder $builder
     * @param Request $request
     */
    public function __construct(
        protected Request $request,
        protected Builder $builder,
        protected $sortable = []
    )
    {}

    public function apply(Builder $builder): Builder
    {
        $this->builder = $builder;

        foreach($this->request->all() as $key => $value) {
            if(method_exists($this, $key)) {
                $this->$key($value);
            }
        }
        return $builder;

    }

    protected function filter($arr) {
        foreach($arr as $key => $value) {
            if(method_exists($this, $key)) {
                $this->$key($value);
            }
        }

        return $this->builder;
    }

    protected function sort($value){
        $sortAttributes = explode(',', $value);

        foreach($sortAttributes as $sortAttribute) {
            $direction = 'asc';

            if(str_starts_with($sortAttribute, '-')) {
                $direction = 'desc';
                $sortAttribute = substr($sortAttribute, 1);
            }

            if(!in_array($sortAttribute, $this->sortable) && !array_key_exists($sortAttribute, $this->sortable)) {
                continue;
            }

            $columnName = $this->sortable[$sortAttribute] ?? null;

            if($columnName === null) {
                $columnName = $sortAttribute;
            }

            $this->builder->orderBy($columnName, $direction);
        }

    }


}