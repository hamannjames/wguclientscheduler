<?php

namespace Services\Filters\ComponentFilters;

use Illuminate\Database\Eloquent\Builder;

class Search extends ComponentFilter
{
    public function applyFilter(Builder $builder)
    {
        $first = true;
        foreach($this->component->searchFields as $field) {
            if ($first) {
                $builder->where($field, 'like', "%{$this->component->search}%");
                $first = false;
            } else {
                $builder->orWhere($field, 'like', "%{$this->component->search}%");
            }
        }

        return $builder;
    }

    public function toString():string {
        return 'search';
    }
}